<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, DashboardController,
    ClientController, LeadController, TaskController,
    InvoiceController, MeetingController, ContentPostController,
    RequisitionController, TargetController, UserController,
    NotificationController, WorklogController, ExpenseController,
    ServiceController, MyWorkItemController
};

Route::middleware(['web', 'auth'])->group(function () {

    // ── Auth ──
    Route::get('/me', [AuthController::class, 'me']);

    // ── Dashboard ──
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    // ── Users (admin only) ──
    Route::get('/users', [UserController::class, 'index']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::middleware('role:owner')->group(function () {
        Route::post('/users',          [UserController::class, 'store']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });

    // ── Services ──
    Route::get('/services',             [ServiceController::class, 'index']);
    Route::middleware('role:owner')->group(function () {
        Route::post('/services',             [ServiceController::class, 'store']);
        Route::put('/services/{service}',    [ServiceController::class, 'update']);
        Route::delete('/services/{service}', [ServiceController::class, 'destroy']);
    });

    // ── Clients ──
    Route::get('/clients',                              [ClientController::class, 'index']);
    Route::post('/clients',                             [ClientController::class, 'store']);
    Route::get('/clients/{client}',                     [ClientController::class, 'show']);
    Route::put('/clients/{client}',                     [ClientController::class, 'update']);
    Route::delete('/clients/{client}',                  [ClientController::class, 'destroy']);
    Route::get('/clients/{client}/custom-statuses',     [ClientController::class, 'customStatuses']);
    Route::post('/clients/{client}/custom-statuses',    [ClientController::class, 'saveCustomStatuses']);

    // ── Leads ──
    Route::get('/leads',                                    [LeadController::class, 'index']);
    Route::post('/leads',                                   [LeadController::class, 'store']);
    Route::put('/leads/{lead}',                             [LeadController::class, 'update']);
    Route::delete('/leads/{lead}',                          [LeadController::class, 'destroy']);
    Route::get('/leads/{lead}/requirements',                [LeadController::class, 'requirements']);
    Route::post('/leads/{lead}/requirements',               [LeadController::class, 'addRequirement']);
    Route::delete('/leads/{lead}/requirements/{requirement}',[LeadController::class, 'removeRequirement']);
    Route::get('/lead-stages',                              [LeadController::class, 'stages']);
    Route::post('/lead-stages',                             [LeadController::class, 'saveStages']);

    // ── Tasks ──
    Route::get('/tasks',                        [TaskController::class, 'index']);
    Route::post('/tasks',                       [TaskController::class, 'store']);
    Route::put('/tasks/{task}',                 [TaskController::class, 'update']);
    Route::delete('/tasks/{task}',              [TaskController::class, 'destroy']);
    Route::patch('/tasks/{task}/status',        [TaskController::class, 'updateStatus']);
    Route::post('/tasks/{task}/breakdown',      [TaskController::class, 'breakdown']);
    Route::post('/tasks/{task}/progress',       [TaskController::class, 'addProgress']);
    Route::post('/tasks/{task}/approve',        [TaskController::class, 'approve']);
    Route::patch('/tasks/{task}/schedule',      [TaskController::class, 'scheduleTask']);
    Route::get('/tasks/workload',               [TaskController::class, 'workload']);
    Route::get('/tasks/dayplan',                [TaskController::class, 'dayPlan']);

    // ── Invoices ──
    Route::middleware('role:owner')->group(function () {
        Route::get('/invoices',                     [InvoiceController::class, 'index']);
        Route::post('/invoices',                    [InvoiceController::class, 'store']);
        Route::put('/invoices/{invoice}',           [InvoiceController::class, 'update']);
        Route::delete('/invoices/{invoice}',        [InvoiceController::class, 'destroy']);
        Route::post('/invoices/{invoice}/reminder', [InvoiceController::class, 'addReminder']);
    });
    Route::get('/reminder-templates',               [InvoiceController::class, 'reminderTemplates']);
    Route::get('/invoices/export/ics',              [InvoiceController::class, 'exportICS']);

    // ── Meetings ──
    Route::get('/meetings',              [MeetingController::class, 'index']);
    Route::post('/meetings',             [MeetingController::class, 'store']);
    Route::put('/meetings/{meeting}',    [MeetingController::class, 'update']);
    Route::get('/meetings/export/ics',   [MeetingController::class, 'exportICS']);

    // ── Content Calendar ──
    Route::get('/content-posts',                    [ContentPostController::class, 'index']);
    Route::post('/content-posts',                   [ContentPostController::class, 'store']);
    Route::put('/content-posts/{contentPost}',      [ContentPostController::class, 'update']);
    Route::delete('/content-posts/{contentPost}',   [ContentPostController::class, 'destroy']);

    // ── Requisitions ──
    Route::get('/requisitions',                         [RequisitionController::class, 'index']);
    Route::post('/requisitions',                        [RequisitionController::class, 'store']);
    Route::post('/requisitions/{requisition}/approve',  [RequisitionController::class, 'approve']);
    Route::post('/requisitions/{requisition}/reject',   [RequisitionController::class, 'reject']);
    Route::post('/requisitions/{requisition}/activate', [RequisitionController::class, 'activate']);

    // ── Targets ──
    Route::get('/targets',                      [TargetController::class, 'index']);
    Route::post('/targets',                     [TargetController::class, 'store']);
    Route::post('/targets/{target}/deals',      [TargetController::class, 'addDeal']);

    // ── Worklogs ──
    Route::get('/worklogs',                     [WorklogController::class, 'index']);
    Route::post('/worklogs',                    [WorklogController::class, 'store']);
    Route::patch('/worklogs/{worklog}/review',  [WorklogController::class, 'review']);

    Route::get('/my-work-items',                 [MyWorkItemController::class, 'index']);
    Route::post('/my-work-items',                [MyWorkItemController::class, 'store']);
    Route::put('/my-work-items/{myWorkItem}',    [MyWorkItemController::class, 'update']);
    Route::delete('/my-work-items/{myWorkItem}', [MyWorkItemController::class, 'destroy']);

    // ── Expenses ──
    Route::get('/expenses',             [ExpenseController::class, 'index']);
    Route::post('/expenses',            [ExpenseController::class, 'store']);
    Route::get('/expenses/categories',  [ExpenseController::class, 'categories']);
    Route::get('/expenses/summary',     [ExpenseController::class, 'summary']);

    // ── Notifications ──
    Route::get('/notifications',            [NotificationController::class, 'index']);
    Route::post('/notifications/read',      [NotificationController::class, 'markRead']);
    Route::post('/notifications/read-all',  [NotificationController::class, 'markAllRead']);
});
