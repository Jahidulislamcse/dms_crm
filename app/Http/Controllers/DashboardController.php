<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Client, Lead, Invoice, Task, Meeting, Expense, Requisition, Service, User};
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Calculate Super Admin Executive Stats
        $monthlyRevenue = Client::where('status', 'active')->get()->sum(function($c) {
            return $c->total_monthly_value;
        });

        $collectedPayments = Invoice::where('status', 'paid')->sum('total');
        
        $pendingPayments = Invoice::whereIn('status', ['unpaid', 'partial'])->sum('balance');
        
        $currentMonthExpenses = Expense::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->sum('amount');
            
        $netProfit = $collectedPayments - $currentMonthExpenses;

        $activeClientsCount = Client::where('status', 'active')->count();
        $totalLeadsCount = Lead::count();
        
        $pendingRequisitions = Requisition::with(['submittedBy', 'items'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $overdueTasks = Task::with(['client', 'assignedTo'])
            ->where('deadline', '<', today())
            ->where('status', '!=', 'done')
            ->get();

        $recentClients = Client::with(['assignedSmm', 'assignedSales'])
            ->latest()
            ->take(5)
            ->get();

        $recentInvoices = Invoice::with('client')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'monthlyRevenue',
            'collectedPayments',
            'pendingPayments',
            'currentMonthExpenses',
            'netProfit',
            'activeClientsCount',
            'totalLeadsCount',
            'pendingRequisitions',
            'overdueTasks',
            'recentClients',
            'recentInvoices'
        ));
    }
}
