<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guest>
 */
class GuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => null,
            'gender' => fake()->boolean() ? Arr::random(['male', 'female']) : null,
            'phone' => '+' . rand(1, 60) . ' ' . rand(),
            'document_type' => null,
            'document' => null,
            'attachments' => fn () => fake()->boolean() ? Arr::map(
                range(1, rand(1, 2)),
                fn ($item) => [
                    'name' => "fake-image-{$item}.jpg",
                    'mime_type' => 'image/jpg',
                    'size' => 150,
                    'path' => 'fake-files/fake-image.jpg',
                    'disk' => 'public',
                ]
            ) : [],
            'children' => fn () => fake()->boolean(50) ? Arr::map(
                range(1, rand(1, 3)),
                fn () => [
                    'name' => fake()->name(),
                    'gender' => fake()->boolean() ? Arr::random(['male', 'female']) : null,
                    'age' => rand(0, 12),
                    'note' => 'fake child',
                    'document_type' => null,
                    'document' => null
                ]
            ) : [],
            'emergency_contacts' => fn () => fake()->boolean() ? Arr::map(
                range(1, rand(1, 2)),
                fn () => [
                    'name' => fake()->name(),
                    'phone' => '+' . rand(1, 60) . ' ' . rand(),
                    'note' => null,
                ]
            ) : [],
            'internal_note' => 'Fake guest',
            'source' => ucwords('Booking Site ' . fake()->word()),
            'partner_code' => 'fake_partner_0' . rand(1, 4),
        ];
    }
}
