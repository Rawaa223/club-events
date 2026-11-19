<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Member;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        // 20 club members
        $members = Member::factory(20)->create();

        // 15 events; recycle() picks each organizer from the members above
        // instead of creating a new member for every event.
        $events = Event::factory(15)->recycle($members)->create();

        // Register a random group of members for each event (never more than the capacity).
        foreach ($events as $event) {
            $howMany = rand(2, min(12, $event->capacity));
            $event->attendees()->attach($members->random($howMany)->pluck('id'));
        }
    }
}
