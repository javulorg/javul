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
            'username'=>'AdminJavul',
            'email' => 'admin@javul.org',
            'password' => bcrypt('123456'),
            'phone'=>'9925633210',
            'mobile'=>'9963256320',
            'address'=>'Address',
            'country_id' => 231,
            'state_id' => 3924,
            'city_id' => 43070,
            'role'=>'superadmin'
        ]);
    }
}
