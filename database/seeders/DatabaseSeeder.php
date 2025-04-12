<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Profissional;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Empresa::factory()->count(10)->create();
        Profissional::factory()->count(10)->create();
    }
}
