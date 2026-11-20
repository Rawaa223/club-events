@extends('layouts.app')

@section('title', 'Events')

@section('content')
    <div class="page-head">
        <h1>Events</h1>
        <a href="{{ route('events.create') }}" class="btn btn-primary">+ New event</a>
    </div>

    <form method="GET" action="{{ route('events.index') }}" class="filters">
        <input type="search" name="q" placeholder="Search title or location…" value="{{ request('q') }}">

        <select name="when">
            <option value="upcoming" @selected($when === 'upcoming')>Upcoming</option>
            <option value="past" @selected($when === 'past')>Past</option>
            <option value="all" @selected($when === 'all')>All</option>
        </select>

        <select name="organizer">
            <option value="">All organizers</option>
            @foreach ($members as $member)
                <option value="{{ $member->id }}" @selected(request('organizer') == $member->id)>{{ $member->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn">Filter</button>
        <a href="{{ route('events.index') }}" class="btn">Reset</a>
    </form>

    @if ($events->isEmpty())
        <p class="muted">No events found.</p>
    @else
        <div class="grid">
            @foreach ($events as $event)
                @include('events._card', ['event' => $event])
            @endforeach
        </div>

        <div style="margin-top:1.5rem">
            {{ $events->links('pagination::simple-bootstrap-4') }}
        </div>
    @endif
@endsection
