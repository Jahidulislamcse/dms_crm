@extends('layouts.app')

@section('title', 'Review Requisition — ' . $requisition->client_name)
@section('header_title', 'Requisition Deal Review')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('requisitions.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1">
            <i class="fa fa-arrow-left"></i> Back to Requisitions Hub
        </a>
    </div>

    <!-- Main Deal Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
            <div>
                <span class="text-xs font-bold text-amber-600 uppercase tracking-wider">Sales Deal Requisition</span>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">{{ $requisition->client_name }}</h2>
                <p class="text-xs text-slate-500 mt-1">Submitted by: <strong>{{ $requisition->submittedBy->name ?? 'Sales Exec' }}</strong> on {{ $requisition->created_at->format('M d, Y') }}</p>
            </div>

            <div class="text-right">
                <span class="block text-2xl font-extrabold text-slate-900 font-mono">৳{{ number_format($requisition->total_value, 2) }}</span>
                <span class="text-xs text-emerald-600 font-bold">Advance Collected: ৳{{ number_format($requisition->advance_paid, 2) }}</span>
            </div>
        </div>

        <!-- Deal Item Lines -->
        <div class="space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Negotiated Service Packages</h3>
            <div class="border border-slate-200/80 rounded-xl overflow-hidden divide-y divide-slate-100 text-xs">
                @foreach($requisition->items as $item)
                <div class="p-4 flex items-center justify-between bg-slate-50/50">
                    <div>
                        <span class="font-bold text-slate-900 text-sm">{{ $item->service_name }}</span>
                        <span class="block text-slate-500 mt-0.5">Qty: {{ $item->qty }} · ৳{{ number_format($item->unit_price, 2) }} per unit</span>
                        @if($item->notes)
                        <p class="text-[11px] text-slate-400 mt-1 italic"><i class="fa fa-info-circle"></i> {{ $item->notes }}</p>
                        @endif
                    </div>
                    <span class="font-mono font-bold text-slate-900 text-sm">৳{{ number_format($item->total, 2) }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Approval / Decision Panel -->
        @if($requisition->status === 'pending')
        <div class="pt-6 border-t border-slate-100 bg-amber-50/50 rounded-2xl p-6 border border-amber-200/80 space-y-4">
            <h3 class="text-sm font-bold text-amber-900 flex items-center gap-2">
                <i class="fa fa-shield-check text-amber-600"></i> Super Admin Approval & Client Activation
            </h3>
            <p class="text-xs text-amber-800">Approving this requisition will automatically create an Active Client profile, attach the agreed service packages, and generate initial onboarding tasks for assigned team members.</p>

            <form action="{{ route('requisitions.approve', $requisition->id) }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Assign SMM Account Manager *</label>
                        <select name="assigned_smm" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                            <option value="">-- Select SMM --</option>
                            @foreach($smmUsers as $smm)
                            <option value="{{ $smm->id }}">{{ $smm->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Assign Creative Team Members</label>
                        <select name="team[]" multiple class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500 h-24">
                            @foreach($teamUsers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ strtoupper($user->role) }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Admin Approval Notes</label>
                    <textarea name="admin_notes" rows="2" placeholder="e.g. Approved. Priority onboarding."
                              class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500"></textarea>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-emerald-600/20 transition-all flex items-center gap-2">
                        <i class="fa fa-check-circle"></i> Approve & Activate Client Account
                    </button>
                </div>
            </form>
        </div>
        @else
        <div class="p-4 rounded-xl {{ $requisition->status === 'approved' ? 'bg-emerald-50 border border-emerald-200 text-emerald-800' : 'bg-rose-50 border border-rose-200 text-rose-800' }} text-xs font-semibold">
            Status: <strong class="uppercase">{{ $requisition->status }}</strong> · Reviewed by {{ $requisition->reviewedBy->name ?? 'Admin' }} on {{ $requisition->reviewed_at ? $requisition->reviewed_at->format('M d, Y') : '—' }}
        </div>
        @endif
    </div>
</div>
@endsection
