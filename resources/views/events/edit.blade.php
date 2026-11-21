@extends('layouts.app')

@section('title', 'Edit ' . $event->title)

@section('content')
    <h1>Edit “{{ $event->title }}”</h1>

    <form method="POST" action="{{ route('events.update', $event) }}" class="card">
        @csrf
        @method('PUT')

        @include('events._form')

        <button type="submit" class="btn btn-primary">Save changes</button>
        <a href="{{ route('events.show', $event) }}" class="btn">Cancel</a>
    </form>
@endsection
