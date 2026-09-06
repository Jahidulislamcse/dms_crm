<div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md hover:border-slate-300 transition-all flex flex-col justify-between space-y-4">
    <div>
        <!-- Card Header Meta -->
        <div class="flex items-center justify-between gap-2 mb-2.5">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-extrabold bg-slate-100 text-slate-700">
                    <i class="fa fa-clock text-amber-500"></i>
                    <span>{{ \Carbon\Carbon::parse($meeting->date)->format('d M, Y') }}</span>
                    @if($meeting->time)
                        <span class="text-slate-400 font-normal">•</span>
                        <span>{{ \Carbon\Carbon::parse($meeting->time)->format('h:i A') }}</span>
                    @endif
                </span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-slate-100 text-slate-500">
                    {{ $meeting->duration }} mins
                </span>
            </div>

            <div class="flex items-center gap-1">
                @if($meeting->status === 'scheduled')
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                        Scheduled
                    </span>
                @elseif($meeting->status === 'completed')
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Completed
                    </span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                        Cancelled
                    </span>
                @endif
            </div>
        </div>

        <!-- Meeting Agenda Title -->
        <a href="{{ route('meetings.show', $meeting->id) }}" class="block group">
            <h3 class="font-bold text-slate-900 text-base group-hover:text-amber-600 transition-all line-clamp-1">
                {{ $meeting->agenda }}
            </h3>
        </a>

        <!-- Related Client or Lead -->
        <div class="mt-2 text-xs font-semibold text-slate-600 flex items-center gap-2">
            <i class="fa fa-user-tie text-slate-400 text-xs"></i>
            <span>Client / Prospect:</span>
            @if($meeting->client)
                <a href="{{ route('clients.show', $meeting->client->id) }}" class="font-bold text-blue-600 hover:underline">
                    {{ $meeting->client->name }}
                </a>
            @elseif($meeting->lead)
                <a href="{{ route('crm.show', $meeting->lead->id) }}" class="font-bold text-amber-600 hover:underline">
                    {{ $meeting->lead->name }} (Lead)
                </a>
            @else
                <span class="font-bold text-slate-800">{{ $meeting->client_name ?? 'General Sync' }}</span>
            @endif
        </div>

        <!-- Location or Online Link -->
        @if($meeting->location)
        <div class="mt-2 text-xs font-medium text-slate-500 flex items-center gap-2">
            <i class="fa fa-location-dot text-rose-400 text-xs"></i>
            @if(filter_var($meeting->location, FILTER_VALIDATE_URL))
                <a href="{{ $meeting->location }}" target="_blank" class="text-blue-600 font-bold hover:underline flex items-center gap-1">
                    <span>Join Online Meeting</span>
                    <i class="fa fa-external-link-alt text-[10px]"></i>
                </a>
            @else
                <span>{{ $meeting->location }}</span>
            @endif
        </div>
        @endif

        <!-- Meeting Outcome Note (if completed) -->
        @if($meeting->outcome)
        <div class="mt-3 p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs text-slate-600">
            <span class="block text-[10px] font-bold text-slate-400 uppercase mb-0.5">Outcome & Minutes</span>
            <p class="line-clamp-2 font-medium">{{ $meeting->outcome }}</p>
        </div>
        @endif
    </div>

    <!-- Card Footer -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
        <!-- Attendees Stack -->
        <div class="flex items-center gap-1">
            <span class="text-[10px] font-bold text-slate-400 uppercase mr-1">Attendees:</span>
            <div class="flex -space-x-1.5 overflow-hidden">
                @forelse($meeting->attendees as $attendee)
                <div class="inline-block h-6 w-6 rounded-full ring-2 ring-white flex items-center justify-center font-bold text-white text-[9px]"
                     style="background-color: {{ $attendee->color ?? '#f59e0b' }}"
                     title="{{ $attendee->name }}">
                    {{ strtoupper(substr($attendee->name, 0, 2)) }}
                </div>
                @empty
                <span class="text-[11px] text-slate-400 font-medium">None assigned</span>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex items-center gap-1.5">
            @if($meeting->status === 'scheduled')
            <button type="button" @click="selectedMeetingId = {{ $meeting->id }}; selectedAgenda = '{{ addslashes($meeting->agenda) }}'; completeModal = true"
                    class="px-2.5 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-lg text-xs font-bold transition-all flex items-center gap-1">
                <i class="fa fa-check text-[10px]"></i> Complete
            </button>
            @endif

            <a href="{{ route('meetings.show', $meeting->id) }}" class="p-1.5 text-slate-500 hover:bg-slate-100 rounded-lg transition-all" title="View Details">
                <i class="fa fa-eye"></i>
            </a>

            <a href="{{ route('meetings.edit', $meeting->id) }}" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit Meeting">
                <i class="fa fa-edit"></i>
            </a>
        </div>
    </div>
</div>
