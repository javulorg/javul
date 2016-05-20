<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => "Javul",
            'last_name'=>'Admin',
            'email' => 'admin@javul.org',
            'password' => bcrypt('123456'),
            'phone'=>'9925633210',
            'mobile'=>'9963256320',
            'address'=>'Address',
            'country_id'=>1,
            'state_id'=>1,
            'city_id'=>1,
            'role'=>'superadmin'
        ]);
    }
}
