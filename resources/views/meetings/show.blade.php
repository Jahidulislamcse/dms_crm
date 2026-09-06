@extends('layouts.app')

@section('title', 'Meeting Details — ' . $meeting->agenda)
@section('header_title', 'Meeting & Appointment Details')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('meetings.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all">
                <i class="fa fa-arrow-left"></i>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">{{ $meeting->agenda }}</h2>
                    @if($meeting->status === 'scheduled')
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-blue-100 text-blue-800 border border-blue-300">
                            Scheduled
                        </span>
                    @elseif($meeting->status === 'completed')
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-300">
                            Completed
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-800 border border-rose-300">
                            Cancelled
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    Scheduled on {{ \Carbon\Carbon::parse($meeting->date)->format('F d, Y') }} by {{ $meeting->createdBy->name ?? 'Admin' }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('meetings.edit', $meeting->id) }}" class="px-3.5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-50 transition-all flex items-center gap-1.5">
                <i class="fa fa-edit text-amber-500"></i> Edit Meeting
            </a>

            <form action="{{ route('meetings.destroy', $meeting->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this meeting?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3.5 py-2.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 font-bold text-xs hover:bg-rose-100 transition-all">
                    <i class="fa fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Grid Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Column: Details & Outcome (7 cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Card 1: Meeting Overview -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                        <i class="fa fa-clock text-amber-500"></i> Schedule Overview
                    </h3>
                    <span class="text-xs font-extrabold text-slate-500">Duration: {{ $meeting->duration }} Minutes</span>
                </div>

                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Date & Time</span>
                        <span class="font-extrabold text-slate-900 text-sm">
                            {{ \Carbon\Carbon::parse($meeting->date)->format('d M, Y') }}
                            @if($meeting->time)
                                at {{ \Carbon\Carbon::parse($meeting->time)->format('h:i A') }}
                            @endif
                        </span>
                    </div>

                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Client / Organization</span>
                        <div class="mt-0.5">
                            @if($meeting->client)
                                <a href="{{ route('clients.show', $meeting->client->id) }}" class="font-bold text-blue-600 hover:underline">
                                    {{ $meeting->client->name }}
                                </a>
                            @elseif($meeting->lead)
                                <a href="{{ route('crm.show', $meeting->lead->id) }}" class="font-bold text-amber-600 hover:underline">
                                    {{ $meeting->lead->name }} (Prospect Lead)
                                </a>
                            @else
                                <span class="font-bold text-slate-800">{{ $meeting->client_name ?? 'Internal Sync' }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-span-2">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Location / Online Video Link</span>
                        <div class="mt-1">
                            @if($meeting->location)
                                @if(filter_var($meeting->location, FILTER_VALIDATE_URL))
                                    <a href="{{ $meeting->location }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 font-bold border border-blue-200 hover:bg-blue-100 transition-all">
                                        <i class="fa fa-video"></i>
                                        <span>Join Google Meet / Online Call</span>
                                        <i class="fa fa-external-link-alt text-[10px]"></i>
                                    </a>
                                @else
                                    <span class="font-bold text-slate-800 flex items-center gap-1.5">
                                        <i class="fa fa-location-dot text-rose-500"></i> {{ $meeting->location }}
                                    </span>
                                @endif
                            @else
                                <span class="font-medium text-slate-400">No location specified</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Outcome & Meeting Minutes -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                        <i class="fa fa-file-lines text-emerald-500"></i> Meeting Minutes & Discussion Outcome
                    </h3>
                </div>

                @if($meeting->outcome)
                <div class="space-y-3">
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Key Discussion & Outcome</span>
                        <p class="text-xs text-slate-800 bg-slate-50 p-3 rounded-xl border border-slate-100 font-medium leading-relaxed whitespace-pre-line">{{ $meeting->outcome }}</p>
                    </div>

                    @if($meeting->next_action)
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Next Action Steps</span>
                        <p class="text-xs text-emerald-800 bg-emerald-50 p-3 rounded-xl border border-emerald-100 font-semibold">{{ $meeting->next_action }}</p>
                    </div>
                    @endif

                    @if($meeting->next_followup)
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Next Scheduled Follow-up</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-amber-50 text-amber-700 font-bold text-xs border border-amber-200">
                            <i class="fa fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($meeting->next_followup)->format('d M, Y') }}
                        </span>
                    </div>
                    @endif
                </div>
                @else
                <div class="py-6 text-center text-slate-400 font-medium text-xs">
                    No outcome or minutes recorded yet for this meeting.
                </div>
                @endif
            </div>

        </div>

        <!-- Right Column: Status Panel & Attendees (5 cols) -->
        <div class="lg:col-span-5 space-y-6">

            <!-- Status Switcher Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                    <i class="fa fa-toggle-on text-purple-500"></i> Status & Log Outcome
                </h3>

                <form action="{{ route('meetings.update-status', $meeting->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Update Status</label>
                        <select name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="scheduled" {{ $meeting->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="completed" {{ $meeting->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $meeting->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Outcome & Minutes</label>
                        <textarea name="outcome" rows="2" placeholder="Record meeting minutes..."
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('outcome', $meeting->outcome) }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2">
                        <i class="fa fa-save"></i> Save Status & Outcome
                    </button>
                </form>
            </div>

            <!-- Team Attendees Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                        <i class="fa fa-users text-blue-500"></i> Invited Team Attendees
                    </h3>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                        {{ $meeting->attendees->count() }} Team Members
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse($meeting->attendees as $attendee)
                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-white text-xs shadow-sm" style="background-color: {{ $attendee->color ?? '#f59e0b' }}">
                            {{ strtoupper(substr($attendee->name, 0, 2)) }}
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900">{{ $attendee->name }}</h4>
                            <span class="text-[10px] text-slate-500 font-semibold">{{ ucfirst($attendee->role) }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 text-xs py-4">No team attendees assigned.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
