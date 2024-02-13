<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OurWorks;

class OurWorksTableSeeder extends Seeder
{
    public function run()
    {
        OurWorks::factory(3)->create();
    }
}
