<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Task, TaskProgress, TaskApprovalComment, Notification};

class TaskController extends Controller
{
    public function index(Request $request) {
        $user  = Auth::user();
        $query = Task::with(['client','assignedTo','assignedBy','progress','approvalComments','subTasks.assignedTo','customStatus']);

        if (!$user->isOwner()) {
            $query->where(function($q) use($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhere('assigned_by', $user->id);
            });
        }

        if ($request->client_id)  $query->where('client_id', $request->client_id);
        if ($request->assigned_to) $query->where('assigned_to', $request->assigned_to);
        if ($request->status)      $query->where('status', $request->status);
        if ($request->mine)        $query->where('assigned_to', $user->id);

        return response()->json($query->whereNull('parent_task_id')->latest()->get());
    }

    public function store(Request $request) {
        $user = Auth::user();
        $validated = $request->validate([
            'title'          => 'required|string',
            'client_id'      => 'nullable|exists:clients,id',
            'assigned_to'    => 'required|exists:users,id',
            'priority'       => 'in:high,medium,low',
            'deadline'       => 'nullable|date',
            'scheduled_date' => 'nullable|date',
            'estimated_hours'=> 'nullable|numeric|min:0',
            'notes'          => 'nullable|string',
            'service_id'     => 'nullable|exists:services,id',
            'qty'            => 'nullable|integer|min:1',
            'recurring_enabled' => 'boolean',
            'parent_task_id' => 'nullable|exists:tasks,id',
        ]);

        $task = Task::create(array_merge($validated, [
            'assigned_by'    => $user->id,
            'status'         => 'pending',
            'recurring_type' => $request->recurring_type,
            'recurring_interval' => $request->recurring_interval ?? 1,
            'recurring_end_date' => $request->recurring_end_date,
        ]));

        Notification::addNotif('📋','#dbeafe',"Task \"{$task->title}\" assigned to {$task->assignedTo->name}");
        return response()->json($task->load(['client','assignedTo','assignedBy','progress']), 201);
    }

    public function update(Request $request, Task $task) {
        $task->update($request->only([
            'title','client_id','assigned_to','priority','deadline','scheduled_date',
            'estimated_hours','notes','service_id','qty','status','custom_status_id',
            'recurring_enabled','recurring_type','recurring_interval','recurring_end_date'
        ]));
        return response()->json($task->load(['client','assignedTo','progress']));
    }

    public function updateStatus(Request $request, Task $task) {
        $oldStatus = $task->status;
        $task->status = $request->status;
        $task->save();

        // Spawn recurring if done
        if ($request->status === 'done' && $task->recurring_enabled) {
            $task->spawnNextRecurrence();
            Notification::addNotif('🔄','#ccfbf1',"Recurring: \"{$task->title}\" next occurrence created");
        }

        // Notify assigned_by when designer submits for review
        if ($request->status === 'done_pending_review') {
            Notification::addNotif('👀','#ede9fe',
                "{$task->assignedTo->name} submitted \"{$task->title}\" for review");
        }

        return response()->json($task->fresh(['assignedTo','progress']));
    }

    public function breakdown(Request $request, Task $task) {
        $request->validate([
            'assignments'         => 'required|array|min:1',
            'assignments.*.user_id' => 'required|exists:users,id',
            'assignments.*.qty'   => 'required|integer|min:1',
            'assignments.*.deadline' => 'nullable|date',
            'total_qty'           => 'required|integer|min:1',
        ]);

        $user     = Auth::user();
        $created  = [];

        foreach ($request->assignments as $a) {
            $designer = \App\Models\User::find($a['user_id']);
            $sub = Task::create([
                'title'       => $task->title . ' [' . $designer->name . ' — ' . $a['qty'] . ' items]',
                'client_id'   => $task->client_id,
                'assigned_to' => $a['user_id'],
                'assigned_by' => $user->id,
                'priority'    => $task->priority,
                'status'      => 'pending',
                'deadline'    => $a['deadline'] ?? $task->deadline,
                'notes'       => "Assigned by {$user->name}: {$a['qty']} items.\n" . ($task->notes ?? ''),
                'service_id'  => $task->service_id,
                'parent_task_id' => $task->id,
                'qty'         => $a['qty'],
                'recurring_enabled' => false,
            ]);

            Notification::addNotif('📋','#dbeafe',
                "\"{$task->title}\" — {$a['qty']} items assigned to {$designer->name}");
            $created[] = $sub;
        }

        $task->qty = $request->total_qty;
        $task->save();

        return response()->json(['created' => count($created), 'sub_tasks' => $created], 201);
    }

    public function addProgress(Request $request, Task $task) {
        $request->validate(['note' => 'required|string']);
        $progress = TaskProgress::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'note'    => $request->note,
            'done'    => $request->done,
            'total'   => $request->total,
        ]);
        return response()->json($progress, 201);
    }

    public function approve(Request $request, Task $task) {
        $task->approval_status = $request->approved ? 'approved' : 'revision';
        if ($request->status === 'approved') {
            $task->status = 'done';
        } else {
            $task->status = 'in_progress';
        }
        $task->save();

        if ($request->comment) {
            TaskApprovalComment::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'text'    => $request->comment,
            ]);
        }

        $verb = $request->approved ? 'approved' : 'sent back for revision';
        Notification::addNotif('✅','#d1fae5',"\"{$task->title}\" {$verb}");

        return response()->json($task->load(['progress','approvalComments.user']));
    }

    public function workload(Request $request) {
        $weekStart = $request->week ?? now()->startOfWeek()->toDateString();
        $weekEnd   = now()->parse($weekStart)->addDays(6)->toDateString();

        $users = \App\Models\User::where('active', true)
            ->whereNotIn('role', ['owner','sales'])
            ->with([
                'tasks' => fn($q) => $q->where('status','!=','done')
                    ->whereNotNull('scheduled_date')
                    ->whereBetween('scheduled_date', [$weekStart, $weekEnd]),
                'meetings' => fn($q) => $q->where('status','scheduled')
                    ->whereBetween('date', [$weekStart, $weekEnd]),
            ])->get();

        return response()->json($users);
    }

    public function dayPlan(Request $request) {
        $user      = Auth::user();
        $weekStart = $request->week ?? now()->startOfWeek()->toDateString();
        $weekEnd   = now()->parse($weekStart)->addDays(6)->toDateString();

        $query = Task::with(['client','assignedTo'])
            ->where('status','!=','done');

        if (!$user->isOwner()) {
            $query->where(function($q) use($user) {
                $q->where('assigned_to', $user->id)->orWhere('assigned_by', $user->id);
            });
        }

        if ($request->user_id) $query->where('assigned_to', $request->user_id);

        $tasks = $query->get();

        return response()->json([
            'scheduled'   => $tasks->whereNotNull('scheduled_date')
                ->whereBetween('scheduled_date', [$weekStart, $weekEnd])->values(),
            'unscheduled' => $tasks->whereNull('scheduled_date')->values(),
        ]);
    }

    public function scheduleTask(Request $request, Task $task) {
        $task->scheduled_date = $request->date;
        $task->save();
        Notification::addNotif('📅','#dbeafe',"\"{$task->title}\" scheduled for {$request->date}");
        return response()->json($task);
    }

    public function destroy(Task $task) {
        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }
}
