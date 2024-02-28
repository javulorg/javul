<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name'   => "Unit",
            'last_name'    =>'Admin',
            'username'     =>'Unit_Admin',
            'email'        => 'unit_admin@javul.org',
            'password'     => Hash::make(123456789),
            'phone'        =>'9925633210',
            'mobile'       =>'9963256320',
            'address'      =>'Address',
            'role'         =>'unit_admin'
//            'role'         =>'superadmin'
        ]);


        User::create([
            'first_name'   => "Site",
            'last_name'    =>'Admin',
            'username'     =>'site_Admin',
            'email'        => 'site_admin@javul.org',
            'password'     => Hash::make(123456789),
            'phone'        =>'9925633210',
            'mobile'       =>'9963256322',
            'address'      =>'Address',
            'role'         =>'super_admin'
//            'role'         =>'superadmin'
        ]);
    }
}
