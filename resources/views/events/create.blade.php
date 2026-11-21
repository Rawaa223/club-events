@extends('layouts.app')

@section('title', 'New event')

@section('content')
    <h1>New event</h1>

    <form method="POST" action="{{ route('events.store') }}" class="card">
        @csrf

        @include('events._form')

        <button type="submit" class="btn btn-primary">Create event</button>
        <a href="{{ route('events.index') }}" class="btn">Cancel</a>
    </form>
@endsection
