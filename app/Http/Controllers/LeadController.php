<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\{Lead, LeadStage, LeadRequirement, LeadTimeline, User, Service, Requisition, RequisitionItem};

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $stages = LeadStage::orderBy('order')->get();
        $salesReps = User::where('active', true)->whereIn('role', ['owner', 'sales'])->get();

        $query = Lead::with(['stage', 'assignedTo', 'createdBy', 'requirements']);

        if ($user && !$user->isOwner()) {
            $query->where('assigned_to', $user->id);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $allLeads = $query->latest()->get();

        // Group leads by stage for Kanban board view
        $kanbanLeads = [];
        foreach ($stages as $stage) {
            $kanbanLeads[$stage->id] = $allLeads->where('stage_id', $stage->id);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'stages' => $stages,
                'leads' => $allLeads
            ]);
        }

        return view('crm.index', compact('stages', 'kanbanLeads', 'allLeads', 'salesReps'));
    }

    public function create()
    {
        $stages = LeadStage::orderBy('order')->get();
        $salesReps = User::where('active', true)->whereIn('role', ['owner', 'sales'])->get();
        $services = Service::where('active', true)->get();

        return view('crm.create', compact('stages', 'salesReps', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'source' => 'required|string|max:100',
            'stage_id' => 'required|exists:lead_stages,id',
            'assigned_to' => 'required|exists:users,id',
            'budget' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'next_followup' => 'nullable|date',
            'requirements' => 'nullable|array',
            'requirements.*.service_name' => 'required|string|max:255',
            'requirements.*.qty' => 'required|integer|min:1',
            'requirements.*.unit_price' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();

        $lead = Lead::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'company' => $validated['company'] ?? null,
            'location' => $validated['location'] ?? null,
            'source' => $validated['source'],
            'stage_id' => $validated['stage_id'],
            'assigned_to' => $validated['assigned_to'],
            'created_by' => $user->id,
            'budget' => $validated['budget'] ?? 0,
            'notes' => $validated['notes'] ?? null,
            'next_followup' => $validated['next_followup'] ?? null,
        ]);

        // Log Timeline
        LeadTimeline::create([
            'lead_id' => $lead->id,
            'user_id' => $user->id,
            'type' => 'created',
            'text' => "Lead created and assigned to " . ($lead->assignedTo->name ?? 'Sales Rep'),
        ]);

        // Add Requirements
        if (!empty($validated['requirements'])) {
            foreach ($validated['requirements'] as $req) {
                LeadRequirement::create([
                    'lead_id' => $lead->id,
                    'service_name' => $req['service_name'],
                    'qty' => $req['qty'],
                    'unit_price' => $req['unit_price'],
                ]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json($lead->load(['stage', 'assignedTo', 'requirements']), 201);
        }

        return redirect()->route('crm.index')->with('success', "Lead '{$lead->name}' added to pipeline!");
    }

    public function show(Lead $lead)
    {
        $lead->load(['stage', 'assignedTo', 'createdBy', 'requirements', 'timelines.user', 'convertedClient']);
        $stages = LeadStage::orderBy('order')->get();
        $salesReps = User::where('active', true)->whereIn('role', ['owner', 'sales'])->get();
        $services = Service::where('active', true)->get();

        return view('crm.show', compact('lead', 'stages', 'salesReps', 'services'));
    }

    public function edit(Lead $lead)
    {
        $lead->load('requirements');
        $stages = LeadStage::orderBy('order')->get();
        $salesReps = User::where('active', true)->whereIn('role', ['owner', 'sales'])->get();

        return view('crm.edit', compact('lead', 'stages', 'salesReps'));
    }

    public function update(Request $request, Lead $lead)
    {
        $oldStageId = $lead->stage_id;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'source' => 'required|string|max:100',
            'stage_id' => 'required|exists:lead_stages,id',
            'assigned_to' => 'required|exists:users,id',
            'budget' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'next_followup' => 'nullable|date',
        ]);

        $lead->update($validated);

        if ($oldStageId !== (int)$validated['stage_id']) {
            $newStage = LeadStage::find($validated['stage_id']);
            LeadTimeline::create([
                'lead_id' => $lead->id,
                'user_id' => Auth::id(),
                'type' => 'stage',
                'text' => "Stage changed to: " . ($newStage->name ?? 'New Stage'),
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json($lead->fresh(['stage', 'assignedTo']));
        }

        return redirect()->route('crm.show', $lead->id)->with('success', "Lead profile updated!");
    }

    public function updateStage(Request $request, Lead $lead)
    {
        $request->validate(['stage_id' => 'required|exists:lead_stages,id']);

        $oldStageId = $lead->stage_id;
        $lead->stage_id = $request->stage_id;
        $lead->save();

        if ($oldStageId !== (int)$request->stage_id) {
            $newStage = LeadStage::find($request->stage_id);
            LeadTimeline::create([
                'lead_id' => $lead->id,
                'user_id' => Auth::id(),
                'type' => 'stage',
                'text' => "Moved lead to: " . ($newStage->name ?? 'Stage'),
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'lead' => $lead->load('stage')]);
        }

        return back()->with('success', "Lead stage updated!");
    }

    public function addTimelineNote(Request $request, Lead $lead)
    {
        $request->validate(['text' => 'required|string']);

        LeadTimeline::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'type' => 'note',
            'text' => $request->text,
        ]);

        return back()->with('success', "Activity note added to timeline!");
    }

    public function convertToRequisition(Request $request, Lead $lead)
    {
        if ($lead->converted_client_id) {
            return back()->with('error', 'This lead has already been converted into a client/requisition!');
        }

        DB::transaction(function() use ($request, $lead) {
            $wonStage = LeadStage::where('name', 'like', '%won%')->first();
            if ($wonStage) {
                $lead->update(['stage_id' => $wonStage->id]);
            }

            $totalVal = $lead->requirements->sum(function($r) {
                return $r->qty * $r->unit_price;
            });
            if ($totalVal == 0 && $lead->budget > 0) {
                $totalVal = $lead->budget;
            }

            $requisition = Requisition::create([
                'lead_id' => $lead->id,
                'submitted_by' => Auth::id(),
                'client_name' => $lead->name,
                'company' => $lead->company ?? $lead->name,
                'phone' => $lead->phone,
                'email' => $lead->email,
                'location' => $lead->location,
                'total_value' => $totalVal,
                'advance_paid' => $request->input('advance_paid', 0),
                'billing_cycle' => $request->input('billing_cycle', 'monthly'),
                'status' => 'pending',
                'special_notes' => "Converted from CRM Lead #{$lead->id}. " . ($lead->notes ?? ''),
            ]);

            foreach ($lead->requirements as $req) {
                RequisitionItem::create([
                    'requisition_id' => $requisition->id,
                    'service_name' => $req->service_name,
                    'qty' => $req->qty,
                    'unit_price' => $req->unit_price,
                    'total' => $req->qty * $req->unit_price,
                ]);
            }

            LeadTimeline::create([
                'lead_id' => $lead->id,
                'user_id' => Auth::id(),
                'type' => 'requisition',
                'text' => "Lead converted into Sales Requisition #{$requisition->id}",
            ]);
        });

        return redirect()->route('requisitions.index')->with('success', "Lead successfully converted into Sales Requisition!");
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Deleted']);
        }

        return redirect()->route('crm.index')->with('success', "Lead deleted!");
    }
}
