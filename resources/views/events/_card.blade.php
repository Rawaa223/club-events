{{-- Partial: one event as a card. Needs $event (with attendees_count loaded). --}}
@php
    // How full the event is, in percent (for the little bar at the bottom).
    $percent = $event->capacity > 0 ? min(100, round($event->attendees_count / $event->capacity * 100)) : 0;
@endphp
<div class="event-card">
    <div class="date">
        <span class="mon">{{ $event->starts_at->format('M') }}</span>
        <span class="day">{{ $event->starts_at->format('d') }}</span>
    </div>

    <h3><a href="{{ route('events.show', $event) }}">{{ $event->title }}</a></h3>

    <div class="info">
        {{ $event->starts_at->format('D, H:i') }} · {{ $event->location }}
        @isset($event->organizer)
            <br>by <a href="{{ route('members.show', $event->organizer) }}">{{ $event->organizer->name }}</a>
        @endisset
    </div>

    <div class="foot">
        <div class="bar"><span style="width: {{ $percent }}%"></span></div>
        <span>{{ $event->attendees_count }} / {{ $event->capacity }}</span>
        @if ($event->isPast())
            <span class="badge past">Past</span>
        @elseif ($event->spotsLeft() === 0)
            <span class="badge full">Full</span>
        @else
            <span class="badge">{{ $event->spotsLeft() }} left</span>
        @endif
    </div>
</div>
