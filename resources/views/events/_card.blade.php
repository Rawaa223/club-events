{{-- Partial: one event as a card. Needs $event (with attendees_count loaded). --}}
<div class="card">
    <h3><a href="{{ route('events.show', $event) }}">{{ $event->title }}</a></h3>
    <div class="muted">
        📅 {{ $event->starts_at->format('D d M Y, H:i') }}<br>
        📍 {{ $event->location }}
        @isset($event->organizer)
            <br>👤 <a href="{{ route('members.show', $event->organizer) }}">{{ $event->organizer->name }}</a>
        @endisset
    </div>
    <p style="margin:.5rem 0 0">
        @if ($event->isPast())
            <span class="badge past">Past</span>
        @elseif ($event->spotsLeft() === 0)
            <span class="badge full">Full</span>
        @else
            <span class="badge">{{ $event->spotsLeft() }} spots left</span>
        @endif
        <span class="muted">{{ $event->attendees_count }} / {{ $event->capacity }} attending</span>
    </p>
</div>
