@extends('layouts.app')

@section('title', 'Schedule New Meeting')
@section('header_title', 'Schedule Meeting & Appointment')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Schedule New Client / Team Meeting</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Set up sales presentations, strategy calls, or project syncs</p>
        </div>
        <a href="{{ route('meetings.index') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-all flex items-center gap-2">
            <i class="fa fa-arrow-left"></i> Back to Meetings
        </a>
    </div>

    <!-- Form Card -->
    <form action="{{ route('meetings.store') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8 space-y-8">
        @csrf

        <!-- Meeting Core Information -->
        <div class="space-y-4">
            <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center font-bold text-xs">
                    <i class="fa fa-calendar-day"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm">Meeting Agenda & Schedule Details</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Meeting Agenda / Subject Title <span class="text-rose-500">*</span></label>
                    <input type="text" name="agenda" required value="{{ old('agenda') }}" placeholder="e.g. Q4 Marketing Strategy & Proposal Review"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                    @error('agenda') <span class="text-rose-500 text-[11px] font-semibold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Link to Active Client (Optional)</label>
                    <select name="client_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                        <option value="">-- Select Active Client --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', request('client_id')) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} ({{ $client->company ?? 'Individual' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Link to Sales Prospect Lead (Optional)</label>
                    <select name="lead_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                        <option value="">-- Select Sales Lead --</option>
                        @foreach($leads as $lead)
                            <option value="{{ $lead->id }}" {{ old('lead_id', request('lead_id')) == $lead->id ? 'selected' : '' }}>
                                {{ $lead->name }} ({{ $lead->company ?? 'Prospect' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Client / Company Name (If not selected above)</label>
                    <input type="text" name="client_name" value="{{ old('client_name') }}" placeholder="e.g. Star Tech Ltd"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Meeting Date <span class="text-rose-500">*</span></label>
                    <input type="date" name="date" required value="{{ old('date', now()->toDateString()) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Meeting Start Time</label>
                    <input type="time" name="time" value="{{ old('time', '11:00') }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Expected Duration <span class="text-rose-500">*</span></label>
                    <select name="duration" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                        <option value="15" {{ old('duration') == 15 ? 'selected' : '' }}>15 Minutes (Quick Sync)</option>
                        <option value="30" {{ old('duration') == 30 ? 'selected' : '' }}>30 Minutes</option>
                        <option value="45" {{ old('duration') == 45 ? 'selected' : '' }}>45 Minutes</option>
                        <option value="60" {{ old('duration', 60) == 60 ? 'selected' : '' }}>1 Hour (Standard)</option>
                        <option value="90" {{ old('duration') == 90 ? 'selected' : '' }}>1.5 Hours</option>
                        <option value="120" {{ old('duration') == 120 ? 'selected' : '' }}>2 Hours (Workshop / Audit)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Location / Google Meet Link</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. https://meet.google.com/abc-defg-hij or Head Office Boardroom"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>
            </div>
        </div>

        <!-- Team Attendees Selection -->
        <div class="space-y-4">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-500/10 text-blue-600 flex items-center justify-center font-bold text-xs">
                        <i class="fa fa-users"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Assign Team Attendees</h3>
                </div>
                <span class="text-xs font-semibold text-slate-500">Select team members to invite</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($teamUsers as $user)
                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-amber-400 bg-slate-50 cursor-pointer transition-all">
                    <input type="checkbox" name="attendees[]" value="{{ $user->id }}"
                           {{ (is_array(old('attendees')) && in_array($user->id, old('attendees'))) || $user->id == auth()->id() ? 'checked' : '' }}
                           class="w-4 h-4 text-amber-500 rounded border-slate-300 focus:ring-amber-500">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-white text-xs shadow-sm" style="background-color: {{ $user->color ?? '#f59e0b' }}">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-slate-800">{{ $user->name }}</span>
                        <span class="block text-[10px] text-slate-500 font-semibold">{{ ucfirst($user->role) }}</span>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('meetings.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold text-xs hover:bg-slate-200 transition-all">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold text-xs shadow-md shadow-amber-500/20 transition-all">
                <i class="fa fa-calendar-check mr-1.5"></i> Schedule Meeting
            </button>
        </div>
    </form>
</div>
@endsection
