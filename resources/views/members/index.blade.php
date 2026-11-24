@extends('layouts.app')

@section('title', 'Members')

@section('content')
    <h1>Members</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Member since</th>
                <th>Organizes</th>
                <th>Attends</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr>
                    <td><a href="{{ route('members.show', $member) }}">{{ $member->name }}</a></td>
                    <td>{{ $member->email }}</td>
                    <td class="muted">{{ $member->joined_at->format('M Y') }}</td>
                    <td>{{ $member->organized_events_count }}</td>
                    <td>{{ $member->attended_events_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
