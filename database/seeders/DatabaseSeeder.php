<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Member;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Demo data: 20 members, 12 events, and some attendees for each event.
     * Run with: php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        $members = Member::factory()->count(20)->create();

        // recycle(): pick each event's organizer from the members above,
        // instead of letting EventFactory create a brand-new member every time.
        $events = Event::factory()->count(12)->recycle($members)->create();

        // Fill the pivot table: each event gets a random group of attendees
        // (never more than its capacity).
        foreach ($events as $event) {
            $count = rand(0, min($event->capacity, 15));
            $event->attendees()->attach($members->random($count)->pluck('id'));
        }
    }
}
