@extends('layouts.app')

@section('title', $event->title)

@section('content')
    <p><a href="{{ route('events.index') }}">← All events</a></p>

    <div class="page-head">
        <h1>{{ $event->title }}</h1>
        <div>
            <a href="{{ route('events.edit', $event) }}" class="btn">Edit</a>
            <form method="POST" action="{{ route('events.destroy', $event) }}" style="display:inline"
                  onsubmit="return confirm('Delete this event?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>

    <div class="card" style="margin-bottom:1.5rem">
        <p class="muted" style="margin-top:0">
            📅 {{ $event->starts_at->format('l d F Y, H:i') }}
            @if ($event->isPast()) <span class="badge past">Past</span> @endif
            <br>📍 {{ $event->location }}
            <br>👤 Organized by
            <a href="{{ route('members.show', $event->organizer) }}">{{ $event->organizer->name }}</a>
        </p>
        @if ($event->description)
            <p>{{ $event->description }}</p>
        @endif
    </div>

    <h2>Attendees ({{ $event->attendees->count() }} / {{ $event->capacity }})</h2>

    @if ($event->attendees->isEmpty())
        <p class="muted">Nobody has registered yet.</p>
    @else
        <table>
            <thead>
                <tr><th>Name</th><th>Email</th><th>Registered on</th></tr>
            </thead>
            <tbody>
                @foreach ($event->attendees as $member)
                    <tr>
                        <td><a href="{{ route('members.show', $member) }}">{{ $member->name }}</a></td>
                        <td>{{ $member->email }}</td>
                        <td class="muted">{{ $member->pivot->created_at?->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
