<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement([
                'Board game night', 'Weekend hike', 'Photography walk', 'Movie night',
                'Coding workshop', 'Football match', 'Book club meeting', 'Cooking class',
                'Beach clean-up', 'Quiz night', 'Chess tournament', 'Welcome party',
            ]),
            'description' => fake()->paragraph(),
            'location' => fake()->randomElement([
                'Club room', 'Main hall', 'Library, room 2', 'City park', 'Sports field', 'Online',
            ]),
            // Some events in the past, most in the future: both scopes have something to show.
            'starts_at' => fake()->dateTimeBetween('-2 months', '+3 months'),
            'capacity' => fake()->numberBetween(8, 40),
            'organizer_id' => Member::factory(),
        ];
    }
}
