@extends('layouts.app')

@section('title', 'Edit Meeting — ' . $meeting->agenda)
@section('header_title', 'Edit Meeting Details')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Edit Scheduled Meeting</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Update agenda, date/time, attendees, or outcome notes</p>
        </div>
        <a href="{{ route('meetings.show', $meeting->id) }}" class="px-3.5 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-all flex items-center gap-2">
            <i class="fa fa-arrow-left"></i> Cancel & Return
        </a>
    </div>

    <!-- Form Card -->
    <form action="{{ route('meetings.update', $meeting->id) }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8 space-y-8">
        @csrf
        @method('PUT')

        <!-- Core Meeting Info -->
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
                    <input type="text" name="agenda" required value="{{ old('agenda', $meeting->agenda) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status</label>
                    <select name="status" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="scheduled" {{ old('status', $meeting->status) === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="completed" {{ old('status', $meeting->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $meeting->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Link to Active Client</label>
                    <select name="client_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="">-- None --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $meeting->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Link to Prospect Lead</label>
                    <select name="lead_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="">-- None --</option>
                        @foreach($leads as $lead)
                            <option value="{{ $lead->id }}" {{ old('lead_id', $meeting->lead_id) == $lead->id ? 'selected' : '' }}>
                                {{ $lead->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Client / Company Name</label>
                    <input type="text" name="client_name" value="{{ old('client_name', $meeting->client_name) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Meeting Date <span class="text-rose-500">*</span></label>
                    <input type="date" name="date" required value="{{ old('date', $meeting->date ? $meeting->date->format('Y-m-d') : '') }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Start Time</label>
                    <input type="time" name="time" value="{{ old('time', $meeting->time) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Duration (Minutes)</label>
                    <input type="number" name="duration" min="15" value="{{ old('duration', $meeting->duration) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Location / Google Meet Link</label>
                    <input type="text" name="location" value="{{ old('location', $meeting->location) }}"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500">
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
                    <h3 class="font-bold text-slate-900 text-sm">Team Attendees</h3>
                </div>
            </div>

            @php $currentAttendeeIds = $meeting->attendees->pluck('id')->toArray(); @endphp
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($teamUsers as $user)
                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-amber-400 bg-slate-50 cursor-pointer transition-all">
                    <input type="checkbox" name="attendees[]" value="{{ $user->id }}"
                           {{ in_array($user->id, old('attendees', $currentAttendeeIds)) ? 'checked' : '' }}
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

        <!-- Outcome & Notes -->
        <div class="space-y-4">
            <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold text-xs">
                    <i class="fa fa-file-lines"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm">Meeting Minutes & Outcome</h3>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Discussion Outcome / Minutes</label>
                    <textarea name="outcome" rows="3" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('outcome', $meeting->outcome) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Next Action Items</label>
                        <input type="text" name="next_action" value="{{ old('next_action', $meeting->next_action) }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Next Follow-up Date</label>
                        <input type="date" name="next_followup" value="{{ old('next_followup', $meeting->next_followup ? $meeting->next_followup->format('Y-m-d') : '') }}"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('meetings.show', $meeting->id) }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold text-xs hover:bg-slate-200 transition-all">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition-all">
                <i class="fa fa-save mr-1.5"></i> Update Meeting
            </button>
        </div>
    </form>
</div>
@endsection
