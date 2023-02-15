<?php

namespace Database\Seeders;

use App\Models\Admin\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $technologies = ["php","laravel","vue","javascript","html","css","sass"];

    foreach($technologies as $technology){
            Technology::create([
                "technology" => $technology 
            ]);



        };
    }
}