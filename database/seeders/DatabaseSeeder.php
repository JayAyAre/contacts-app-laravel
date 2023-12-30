<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    Cache::flush();
    $testUser = User::factory()->hasContacts(30)->createOne([
        'name' => 'test',
        'email' => 'test@test.com',
        'email_verified_at' => now(),
        'password' => Hash::make('test1234'),
    ]);
    $users = User::factory(3)->hasContacts(12)->create()
        ->each(fn($user) => $user->contacts()->first()->sharedWithUsers()->attach($testUser->id));

    $testUser->contacts()->first()->sharedWithUsers()->attach($users->pluck('id'));
  }
}
