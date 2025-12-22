<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'JayArtist',
            'email'    => 'artist@example.com',
            'password' => app('hash')->make('password'), // hash the password
            'role'     => 'artist',
        ]);
    }
}
