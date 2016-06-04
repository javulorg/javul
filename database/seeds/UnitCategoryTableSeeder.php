<?php

use Illuminate\Database\Seeder;

class UnitCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unit_category')->insert([
            [
                'name' => "Software",
                'status'=>'approved'
            ],
            [
                'name' => "Hardware",
                'status'=>'approved'
            ],
            [
                'name' => "Automobile",
                'status'=>'approved'
            ],
            [
                'name' => "Mechanical",
                'status'=>'approved'
            ]
        ]);
    }
}
