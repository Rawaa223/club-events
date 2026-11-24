@extends('layouts.app')

@section('title', $member->name)

@section('content')
    <p><a href="{{ route('members.index') }}">← All members</a></p>

    <h1>{{ $member->name }}</h1>
    <p class="muted">
        {{ $member->email }}
        @if ($member->phone) · {{ $member->phone }} @endif
        · member since {{ $member->joined_at->format('F Y') }}
    </p>

    <h2>Events organized by {{ $member->name }} ({{ $organized->count() }})</h2>
    @if ($organized->isEmpty())
        <p class="muted">This member has not organized any event.</p>
    @else
        <div class="grid">
            @foreach ($organized as $event)
                @include('events._card', ['event' => $event])
            @endforeach
        </div>
    @endif

    <h2 style="margin-top:2rem">Upcoming events {{ $member->name }} attends ({{ $attending->count() }})</h2>
    @if ($attending->isEmpty())
        <p class="muted">No upcoming registrations.</p>
    @else
        <div class="grid">
            @foreach ($attending as $event)
                @include('events._card', ['event' => $event])
            @endforeach
        </div>
    @endif
@endsection
