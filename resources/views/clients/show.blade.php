@extends('layouts.app')

@section('title', 'Client Profile — ' . $client->name)
@section('header_title', 'Client Profile Overview')

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-slate-900 text-white rounded-2xl p-6 shadow-xl relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-amber-500 text-white font-extrabold text-2xl flex items-center justify-center shadow-lg shadow-amber-500/30">
                {{ strtoupper(substr($client->name, 0, 2)) }}
            </div>
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-extrabold tracking-tight">{{ $client->name }}</h2>
                    <span class="px-3 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $client->status === 'active' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-amber-500/20 text-amber-300' }}">
                        {{ $client->status }}
                    </span>
                </div>
                <p class="text-xs text-slate-400 mt-1">{{ $client->company ?? 'Independent Client' }} · {{ $client->location ?? 'Bangladesh' }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('clients.edit', $client->id) }}" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl transition-all shadow-md">
                <i class="fa fa-edit mr-1"></i> Edit Profile
            </a>
            <a href="{{ route('clients.index') }}" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs rounded-xl transition-all">
                Back
            </a>
        </div>
    </div>

    <!-- 3-Column Info Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Client Details & Assigned Team -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-6">
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">Contact Details</h3>
                <div class="space-y-3 text-xs">
                    <div>
                        <span class="block text-slate-400 text-[10px] uppercase font-semibold">Phone (WhatsApp)</span>
                        <span class="font-bold text-slate-900">{{ $client->phone ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 text-[10px] uppercase font-semibold">Email</span>
                        <span class="font-bold text-slate-900">{{ $client->email ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 text-[10px] uppercase font-semibold">Billing Cycle</span>
                        <span class="font-bold text-slate-900 uppercase">{{ $client->billing_cycle }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 text-[10px] uppercase font-semibold">Onboarded Date</span>
                        <span class="font-bold text-slate-900">{{ $client->onboarded_at ? $client->onboarded_at->format('M d, Y') : '—' }}</span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">Assigned Account Team</h3>
                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div>
                            <span class="block text-[10px] font-bold text-slate-400 uppercase">Assigned SMM</span>
                            <span class="font-bold text-slate-900">{{ $client->assignedSmm->name ?? 'Unassigned' }}</span>
                        </div>
                        <i class="fa fa-user-check text-emerald-500"></i>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div>
                            <span class="block text-[10px] font-bold text-slate-400 uppercase">Sales Representative</span>
                            <span class="font-bold text-slate-900">{{ $client->assignedSales->name ?? 'Unassigned' }}</span>
                        </div>
                        <i class="fa fa-handshake text-blue-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Package Subscriptions (2 cols) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900">Service Package Subscriptions</h3>
                    <span class="text-xs font-bold text-emerald-600 font-mono">Total: ৳{{ number_format($client->total_monthly_value, 2) }}/mo</span>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($client->clientServices as $cs)
                    <div class="py-3 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 font-bold flex items-center justify-center">
                                <i class="fa fa-tag"></i>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900">{{ $cs->service->name ?? $cs->custom_name }}</span>
                                <span class="block text-[11px] text-slate-400">Qty: {{ $cs->qty }} · ৳{{ number_format($cs->price, 2) }} per unit</span>
                            </div>
                        </div>
                        <span class="font-bold text-slate-900 font-mono">৳{{ number_format($cs->price * $cs->qty, 2) }}</span>
                    </div>
                    @empty
                    <div class="py-6 text-center text-slate-400 text-xs">No services attached to client.</div>
                    @endforelse
                </div>
            </div>

            <!-- Invoices History -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-900 pb-3 border-b border-slate-100">Invoice History</h3>
                <div class="divide-y divide-slate-100">
                    @forelse($client->invoices as $invoice)
                    <div class="py-3 flex items-center justify-between text-xs">
                        <div>
                            <span class="font-bold text-slate-900">{{ $invoice->invoice_number }}</span>
                            <span class="block text-[11px] text-slate-400">Issued: {{ $invoice->issued_date->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="font-mono font-bold text-slate-900">৳{{ number_format($invoice->total, 2) }}</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $invoice->status === 'paid' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                {{ $invoice->status }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="py-4 text-center text-slate-400 text-xs">No invoices issued yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
