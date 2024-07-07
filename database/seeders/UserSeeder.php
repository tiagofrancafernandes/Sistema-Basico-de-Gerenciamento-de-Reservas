<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->initialUsers();
        $this->demoUsers();
        $this->fakeUsers();
    }

    public function initialUsers(): void
    {
        $initialUsers = [
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => 'power@123',
            ],
        ];

        foreach ($initialUsers as $item) {
            /**
             * @var User $userData
             */
            $userData = User::factory()->password($item['password'] ?? 'power@123')->make($item);

            User::updateOrCreate([
                'email' => $userData?->email,
            ], $userData?->setHidden([])?->toArray());
        }
    }

    public function demoUsers(): void
    {
        if (!config('app.demo_mode', false)) {
            return;
        }

        foreach (static::getDemoUsers() as $item) {
            /**
             * @var User $userData
             */
            $userData = User::factory()->password($item['password'] ?? null)->make(\Arr::except($item, ['role', 'password']));

            User::updateOrCreate([
                'email' => $userData?->email,
            ], $userData?->setHidden([])?->toArray());
        }
    }

    public function fakeUsers(?int $count = null): void
    {
        User::factory($count ?? 4)->create();
    }

    public static function getDemoUsers(): array
    {
        return [
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => 'power@123',
                'role' => 'Admin',
            ],
            [
                'name' => 'Demo Admin',
                'email' => 'admin@demo.com',
                'password' => 'demo1234',
                'role' => 'Admin',
            ],
            [
                'name' => 'Demo Customer',
                'email' => 'customer@demo.com',
                'password' => 'demo1234',
                'role' => 'Customer',
            ],
        ];
    }
}
