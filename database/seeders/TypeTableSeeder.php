<?php

namespace Database\Seeders;

use App\Models\Admin\Type;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $types = ["work","practice","school"];

    foreach($types as $type){
            Type::create([
                "type" => $type 
            ]);



        };
    }
}
