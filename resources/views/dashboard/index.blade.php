@extends('layouts.app')

@section('title', 'Super Admin Executive Dashboard')
@section('header_title', 'Super Admin Executive Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Top Stat Widgets Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
        <!-- Monthly Revenue -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Monthly MRR</span>
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    <i class="fa fa-dollar-sign"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 tracking-tight">৳{{ number_format($monthlyRevenue, 2) }}</div>
            <p class="text-[11px] text-slate-400 font-semibold mt-1">Active client packages</p>
        </div>

        <!-- Collected Payments -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Collected</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i class="fa fa-arrow-down"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-emerald-600 tracking-tight">৳{{ number_format($collectedPayments, 2) }}</div>
            <p class="text-[11px] text-slate-400 font-semibold mt-1">Paid invoices total</p>
        </div>

        <!-- Pending Invoice Balances -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Due Balances</span>
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                    <i class="fa fa-clock"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-rose-600 tracking-tight">৳{{ number_format($pendingPayments, 2) }}</div>
            <p class="text-[11px] text-slate-400 font-semibold mt-1">Unpaid balance total</p>
        </div>

        <!-- Monthly Expenses -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">May Expenses</span>
                <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                    <i class="fa fa-receipt"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-purple-600 tracking-tight">৳{{ number_format($currentMonthExpenses, 2) }}</div>
            <p class="text-[11px] text-slate-400 font-semibold mt-1">Operating costs</p>
        </div>

        <!-- Net Profit -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Net Profit</span>
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i class="fa fa-chart-line"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold {{ $netProfit >= 0 ? 'text-emerald-600' : 'text-rose-600' }} tracking-tight">
                ৳{{ number_format($netProfit, 2) }}
            </div>
            <p class="text-[11px] text-slate-400 font-semibold mt-1">Collected minus expenses</p>
        </div>
    </div>

    <!-- Requisitions Approval Banner -->
    @if($pendingRequisitions->count() > 0)
    <div class="bg-gradient-to-r from-amber-500 to-amber-600 rounded-2xl p-6 text-white shadow-xl shadow-amber-500/20">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-xl">
                    <i class="fa fa-clipboard-check"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold">Requisitions Awaiting Your Approval ({{ $pendingRequisitions->count() }})</h3>
                    <p class="text-xs text-amber-100 mt-0.5">Sales reps submitted new client deals that need Super Admin sign-off for client account activation.</p>
                </div>
            </div>
            <a href="{{ route('requisitions.index') }}" class="px-4 py-2 bg-white text-amber-700 font-bold text-xs rounded-xl shadow-sm hover:bg-amber-50 transition-all">
                Review All Deals →
            </a>
        </div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3 pt-4 border-t border-white/20">
            @foreach($pendingRequisitions->take(2) as $req)
            <div class="bg-white/10 rounded-xl p-3.5 backdrop-blur-sm flex items-center justify-between">
                <div>
                    <span class="block text-sm font-extrabold text-white">{{ $req->client_name }}</span>
                    <span class="text-xs text-amber-100">By {{ $req->submittedBy->name ?? 'Sales' }} — ৳{{ number_format($req->total_value, 2) }}</span>
                </div>
                <a href="{{ route('requisitions.show', $req->id) }}" class="px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white font-bold text-xs rounded-lg transition-all">
                    Approve / Review
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Main Grid Content: Client Overview & Financial Alerts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Active Clients Overview (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Active Clients Overview</h3>
                    <p class="text-xs text-slate-500">Super Admin client management & assigned team members</p>
                </div>
                <a href="{{ route('clients.index') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700 flex items-center gap-1">
                    View All Clients ({{ $activeClientsCount }}) <i class="fa fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentClients as $client)
                <div class="py-3.5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 text-amber-400 font-bold flex items-center justify-center text-sm">
                            {{ strtoupper(substr($client->name, 0, 2)) }}
                        </div>
                        <div>
                            <a href="{{ route('clients.show', $client->id) }}" class="text-sm font-bold text-slate-900 hover:text-amber-600 transition-all">
                                {{ $client->name }}
                            </a>
                            <p class="text-xs text-slate-500">{{ $client->company ?? 'No company specified' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="text-right hidden sm:block">
                            <span class="block text-xs font-bold text-slate-900 font-mono">৳{{ number_format($client->total_monthly_value, 2) }}/mo</span>
                            <span class="text-[10px] text-slate-400">SMM: {{ $client->assignedSmm->name ?? 'Unassigned' }}</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Active
                        </span>
                        <a href="{{ route('clients.show', $client->id) }}" class="text-slate-400 hover:text-slate-700">
                            <i class="fa fa-chevron-right text-xs"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center text-slate-400">
                    <i class="fa fa-users text-3xl mb-2 text-slate-300"></i>
                    <p class="text-sm">No clients registered yet.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Side Panel: Overdue Alerts & Quick Actions -->
        <div class="space-y-6">
            <!-- Overdue Tasks Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa fa-exclamation-triangle text-rose-500"></i> Overdue Tasks Alert
                    </h3>
                    <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full">
                        {{ $overdueTasks->count() }}
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse($overdueTasks->take(4) as $task)
                    <div class="p-3 rounded-xl bg-rose-50/50 border border-rose-100 text-xs space-y-1">
                        <div class="flex items-center justify-between font-bold text-slate-900">
                            <span class="truncate">{{ $task->title }}</span>
                            <span class="text-rose-600 font-mono">{{ $task->deadline->format('M d') }}</span>
                        </div>
                        <p class="text-slate-500 text-[11px]">
                            Assigned to: <strong class="text-slate-700">{{ $task->assignedTo->name ?? 'Unassigned' }}</strong>
                        </p>
                    </div>
                    @empty
                    <div class="py-4 text-center text-slate-400 text-xs">
                        <i class="fa fa-check-circle text-emerald-500 text-xl block mb-1"></i>
                        No overdue tasks! Everything is on schedule.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Action Shortcuts -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-3">
                <h3 class="text-sm font-bold text-slate-900 mb-2">Super Admin Actions</h3>
                
                <a href="{{ route('clients.create') }}" class="w-full flex items-center justify-between p-3 rounded-xl bg-amber-50 text-amber-800 hover:bg-amber-100 font-semibold text-xs transition-all">
                    <span class="flex items-center gap-2"><i class="fa fa-user-plus"></i> Add New Client</span>
                    <i class="fa fa-arrow-right"></i>
                </a>

                <a href="{{ route('team.create') }}" class="w-full flex items-center justify-between p-3 rounded-xl bg-blue-50 text-blue-800 hover:bg-blue-100 font-semibold text-xs transition-all">
                    <span class="flex items-center gap-2"><i class="fa fa-user-gear"></i> Register Team Member</span>
                    <i class="fa fa-arrow-right"></i>
                </a>

                <a href="{{ route('services.index') }}" class="w-full flex items-center justify-between p-3 rounded-xl bg-emerald-50 text-emerald-800 hover:bg-emerald-100 font-semibold text-xs transition-all">
                    <span class="flex items-center gap-2"><i class="fa fa-tags"></i> Manage Services</span>
                    <i class="fa fa-arrow-right"></i>
                </a>

                <a href="{{ route('expenses.index') }}" class="w-full flex items-center justify-between p-3 rounded-xl bg-purple-50 text-purple-800 hover:bg-purple-100 font-semibold text-xs transition-all">
                    <span class="flex items-center gap-2"><i class="fa fa-receipt"></i> Log Agency Expense</span>
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
