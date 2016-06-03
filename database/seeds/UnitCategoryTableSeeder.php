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
            'name' => "Computers",
            'status'=>'approved'
        ]);
    }
}
