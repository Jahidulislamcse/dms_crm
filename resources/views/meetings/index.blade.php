@extends('layouts.app')

@section('title', 'Meetings & Appointments Calendar')
@section('header_title', 'Client Meetings & Schedule Hub')

@section('content')
<div class="space-y-6" x-data="{ tab: 'upcoming', completeModal: false, selectedMeetingId: null, selectedAgenda: '' }">

    <!-- Top Action Bar & Header -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Meetings & Appointments Schedule</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Organize sales calls, client strategy sessions, and team syncs</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('meetings.create') }}" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold text-xs shadow-md shadow-amber-500/20 flex items-center gap-2 transition-all">
                <i class="fa fa-calendar-plus text-sm"></i>
                <span>Schedule New Meeting</span>
            </a>
        </div>
    </div>

    <!-- Metrics Cards Overview -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-600 flex items-center justify-center font-bold text-xl">
                <i class="fa fa-calendar-alt"></i>
            </div>
            <div>
                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Scheduled Upcoming</span>
                <h4 class="text-lg font-extrabold text-blue-600">{{ $upcomingMeetings->count() }}</h4>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold text-xl">
                <i class="fa fa-calendar-check"></i>
            </div>
            <div>
                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Completed</span>
                <h4 class="text-lg font-extrabold text-emerald-600">{{ $allMeetings->where('status', 'completed')->count() }}</h4>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center font-bold text-xl">
                <i class="fa fa-handshake"></i>
            </div>
            <div>
                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Meetings</span>
                <h4 class="text-lg font-extrabold text-slate-900">{{ $allMeetings->count() }}</h4>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-500/10 text-rose-600 flex items-center justify-center font-bold text-xl">
                <i class="fa fa-calendar-xmark"></i>
            </div>
            <div>
                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Cancelled</span>
                <h4 class="text-lg font-extrabold text-rose-600">{{ $allMeetings->where('status', 'cancelled')->count() }}</h4>
            </div>
        </div>
    </div>

    <!-- Filter & Tab Controls -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-3">
            <!-- Tabs -->
            <div class="flex items-center gap-2">
                <button @click="tab = 'upcoming'"
                        :class="tab === 'upcoming' ? 'bg-amber-500 text-white font-bold shadow-md shadow-amber-500/20' : 'bg-slate-100 text-slate-600 font-semibold hover:bg-slate-200'"
                        class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-2">
                    <i class="fa fa-clock"></i>
                    <span>Upcoming Meetings</span>
                    <span class="ml-1 px-2 py-0.5 rounded-full text-[10px] bg-white/20 text-white font-extrabold">
                        {{ $upcomingMeetings->count() }}
                    </span>
                </button>

                <button @click="tab = 'past'"
                        :class="tab === 'past' ? 'bg-slate-900 text-white font-bold shadow-sm' : 'bg-slate-100 text-slate-600 font-semibold hover:bg-slate-200'"
                        class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-2">
                    <i class="fa fa-history"></i>
                    <span>Past & Completed</span>
                    <span class="ml-1 px-2 py-0.5 rounded-full text-[10px] bg-slate-200 text-slate-700 font-extrabold">
                        {{ $pastMeetings->count() }}
                    </span>
                </button>

                <button @click="tab = 'all'"
                        :class="tab === 'all' ? 'bg-slate-900 text-white font-bold shadow-sm' : 'bg-slate-100 text-slate-600 font-semibold hover:bg-slate-200'"
                        class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-2">
                    <i class="fa fa-list"></i>
                    <span>All History</span>
                </button>
            </div>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('meetings.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <i class="fa fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search agenda, client name, location..."
                           class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>
            </div>

            <div class="w-44">
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                    <option value="">All Statuses</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition-all">
                <i class="fa fa-filter mr-1"></i> Filter
            </button>

            @if(request()->anyFilled(['search', 'status']))
            <a href="{{ route('meetings.index') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200 transition-all">
                <i class="fa fa-rotate-left mr-1"></i> Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Meetings Cards Grid -->
    <div class="space-y-4">
        @php
            $displayMeetings = match('tab') {
                'upcoming' => $upcomingMeetings,
                'past' => $pastMeetings,
                default => $allMeetings,
            };
        @endphp

        <!-- Upcoming Tab View -->
        <div x-show="tab === 'upcoming'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($upcomingMeetings as $meeting)
                @include('meetings._card', ['meeting' => $meeting])
            @empty
                <div class="md:col-span-2 py-12 text-center bg-white rounded-2xl border border-dashed border-slate-200">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-xl">
                        <i class="fa fa-calendar-day"></i>
                    </div>
                    <h4 class="font-bold text-slate-700 text-sm">No upcoming meetings scheduled</h4>
                    <p class="text-xs text-slate-400 mt-1">Schedule a meeting to sync with prospects or clients.</p>
                </div>
            @endforelse
        </div>

        <!-- Past Tab View -->
        <div x-show="tab === 'past'" class="grid grid-cols-1 md:grid-cols-2 gap-4" x-cloak>
            @forelse($pastMeetings as $meeting)
                @include('meetings._card', ['meeting' => $meeting])
            @empty
                <div class="md:col-span-2 py-12 text-center bg-white rounded-2xl border border-dashed border-slate-200">
                    <h4 class="font-bold text-slate-700 text-sm">No past meetings found</h4>
                </div>
            @endforelse
        </div>

        <!-- All Tab View -->
        <div x-show="tab === 'all'" class="grid grid-cols-1 md:grid-cols-2 gap-4" x-cloak>
            @forelse($allMeetings as $meeting)
                @include('meetings._card', ['meeting' => $meeting])
            @empty
                <div class="md:col-span-2 py-12 text-center bg-white rounded-2xl border border-dashed border-slate-200">
                    <h4 class="font-bold text-slate-700 text-sm">No meetings recorded</h4>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Complete Meeting Modal -->
    <div x-show="completeModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-4" @click.outside="completeModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                    <i class="fa fa-calendar-check text-emerald-500"></i> Mark Meeting Completed
                </h3>
                <button @click="completeModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa fa-times"></i></button>
            </div>

            <p class="text-xs text-slate-600 font-semibold">
                Agenda: <span class="font-bold text-slate-900" x-text="selectedAgenda"></span>
            </p>

            <form :action="`/meetings/${selectedMeetingId}/status`" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="status" value="completed">

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Meeting Discussion & Outcome <span class="text-rose-500">*</span></label>
                    <textarea name="outcome" rows="3" required placeholder="Key discussion points, client feedback, agreed terms..."
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Next Action Items</label>
                    <input type="text" name="next_action" placeholder="e.g. Send formal proposal by tomorrow"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Next Follow-up Date</label>
                    <input type="date" name="next_followup"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" @click="completeModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 shadow-md shadow-emerald-500/20">
                        <i class="fa fa-check mr-1"></i> Complete & Save Outcome
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
