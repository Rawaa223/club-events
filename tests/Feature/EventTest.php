<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_events_list_is_displayed(): void
    {
        $event = Event::factory()->create(['starts_at' => now()->addWeek()]);

        $this->get(route('events.index'))
            ->assertOk()
            ->assertSee($event->title);
    }

    public function test_an_event_can_be_created_with_attendees(): void
    {
        $organizer = Member::factory()->create();
        $attendees = Member::factory(2)->create();

        $response = $this->post(route('events.store'), [
            'title' => 'Quiz night',
            'location' => 'Club room',
            'starts_at' => now()->addDays(3)->format('Y-m-d\TH:i'),
            'capacity' => 10,
            'organizer_id' => $organizer->id,
            'attendees' => $attendees->pluck('id')->all(),
        ]);

        $event = Event::firstWhere('title', 'Quiz night');
        $response->assertRedirect(route('events.show', $event));
        $this->assertCount(2, $event->attendees);
    }

    public function test_invalid_data_returns_errors(): void
    {
        $this->from(route('events.create'))
            ->post(route('events.store'), ['title' => 'ab', 'capacity' => 0])
            ->assertRedirect(route('events.create'))
            ->assertSessionHasErrors(['title', 'location', 'starts_at', 'capacity', 'organizer_id']);
    }

    public function test_attendees_cannot_exceed_capacity(): void
    {
        $organizer = Member::factory()->create();
        $attendees = Member::factory(3)->create();

        $this->post(route('events.store'), [
            'title' => 'Tiny event',
            'location' => 'Club room',
            'starts_at' => now()->addDay()->format('Y-m-d\TH:i'),
            'capacity' => 2,
            'organizer_id' => $organizer->id,
            'attendees' => $attendees->pluck('id')->all(),
        ])->assertSessionHasErrors('attendees');
    }

    public function test_an_event_can_be_deleted(): void
    {
        $event = Event::factory()->create();

        $this->delete(route('events.destroy', $event))
            ->assertRedirect(route('events.index'));

        $this->assertModelMissing($event);
    }

    public function test_the_json_route_only_returns_upcoming_events(): void
    {
        Event::factory()->create(['title' => 'Future', 'starts_at' => now()->addDay()]);
        Event::factory()->create(['title' => 'Old', 'starts_at' => now()->subDay()]);

        $this->getJson(route('events.json'))
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.title', 'Future');
    }

    public function test_member_page_shows_their_organized_events(): void
    {
        $member = Member::factory()->create();
        $event = Event::factory()->create(['organizer_id' => $member->id]);

        $this->get(route('members.show', $member))
            ->assertOk()
            ->assertSee($event->title);
    }
}
