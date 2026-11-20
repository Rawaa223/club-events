<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /** GET /events — list with filters: ?when=upcoming|past|all, ?organizer=ID, ?q=search */
    public function index(Request $request)
    {
        $when = $request->query('when', 'upcoming');

        $query = Event::with('organizer')
            ->withCount('attendees')
            ->search($request->query('q'));

        $query = match ($when) {
            'past' => $query->past(),
            'all' => $query->orderBy('starts_at'),
            default => $query->upcoming(),
        };

        if ($request->filled('organizer')) {
            $query->where('organizer_id', $request->query('organizer'));
        }

        $events = $query->paginate(9)->withQueryString();
        $members = Member::orderBy('name')->get();

        return view('events.index', compact('events', 'members', 'when'));
    }

    /** GET /events/create */
    public function create()
    {
        return view('events.create', [
            'event' => new Event(),
            'members' => Member::orderBy('name')->get(),
        ]);
    }

    /** POST /events */
    public function store(EventRequest $request)
    {
        $event = Event::create($request->safe()->except('attendees'));
        $event->attendees()->sync($request->validated('attendees', []));

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Event created.');
    }

    /** GET /events/{event} */
    public function show(Event $event)
    {
        $event->load(['organizer', 'attendees' => fn ($q) => $q->orderBy('name')]);

        return view('events.show', compact('event'));
    }

    /** GET /events/{event}/edit */
    public function edit(Event $event)
    {
        $event->load('attendees');

        return view('events.edit', [
            'event' => $event,
            'members' => Member::orderBy('name')->get(),
        ]);
    }

    /** PUT /events/{event} */
    public function update(EventRequest $request, Event $event)
    {
        $event->update($request->safe()->except('attendees'));
        $event->attendees()->sync($request->validated('attendees', []));

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Event updated.');
    }

    /** DELETE /events/{event} */
    public function destroy(Event $event)
    {
        $event->delete(); // the pivot rows are removed by cascadeOnDelete

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted.');
    }

    /** GET /api/events — upcoming events as JSON */
    public function json(): JsonResponse
    {
        $events = Event::upcoming()
            ->with('organizer')
            ->withCount('attendees')
            ->get()
            ->map(fn (Event $event) => [
                'id' => $event->id,
                'title' => $event->title,
                'location' => $event->location,
                'starts_at' => $event->starts_at->toIso8601String(),
                'capacity' => $event->capacity,
                'attendees' => $event->attendees_count,
                'organizer' => $event->organizer->name,
                'url' => route('events.show', $event),
            ]);

        return response()->json($events);
    }
}
