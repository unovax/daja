<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Client;
use App\Models\Folio;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Folio::create([
            'prefix' => 'INV',
            'consecutive' => 1,
            'type' => 'I'
        ]);
        //Client::factory()->count(1000)->create();
    }
}
