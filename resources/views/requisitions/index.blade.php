@extends('layouts.app')

@section('title', 'Requisitions Approval Hub')
@section('header_title', 'Super Admin Requisitions Hub')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-base font-bold text-slate-900">Sales Deal Requisitions</h2>
            <p class="text-xs text-slate-500">Review won deals submitted by sales executives for Super Admin approval & client account activation.</p>
        </div>

        <form action="{{ route('requisitions.index') }}" method="GET" class="flex items-center gap-3">
            <select name="status" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-amber-500">
                <option value="">All Requisitions</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Review</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved & Activated</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </form>
    </div>

    <!-- Requisition Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-6">Client / Prospect Name</th>
                        <th class="py-3.5 px-6">Submitted By</th>
                        <th class="py-3.5 px-6">Total Deal Value</th>
                        <th class="py-3.5 px-6">Advance Paid</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($requisitions as $req)
                    <tr class="hover:bg-slate-50/60 transition-all">
                        <td class="py-4 px-6 font-semibold text-slate-900">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 font-bold flex items-center justify-center text-xs">
                                    <i class="fa fa-clipboard-check"></i>
                                </div>
                                <div>
                                    <a href="{{ route('requisitions.show', $req->id) }}" class="font-bold text-slate-900 hover:text-amber-600 transition-all block">
                                        {{ $req->client_name }}
                                    </a>
                                    <span class="text-[11px] text-slate-400 font-normal">{{ $req->company ?? 'No company' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-slate-700 font-medium">
                            {{ $req->submittedBy->name ?? 'Sales Rep' }}
                        </td>
                        <td class="py-4 px-6 font-mono font-bold text-slate-900">
                            ৳{{ number_format($req->total_value, 2) }}
                        </td>
                        <td class="py-4 px-6 font-mono font-bold text-emerald-600">
                            ৳{{ number_format($req->advance_paid, 2) }}
                        </td>
                        <td class="py-4 px-6">
                            @if($req->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">
                                Pending Approval
                            </span>
                            @elseif($req->status === 'approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Approved & Live
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                Rejected
                            </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('requisitions.show', $req->id) }}" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg transition-all">
                                Review Deal →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="fa fa-inbox text-4xl mb-3 text-slate-300 block"></i>
                            <p class="text-sm font-semibold">No sales requisitions found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requisitions->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $requisitions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
