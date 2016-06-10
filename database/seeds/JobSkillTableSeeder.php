<?php

use Illuminate\Database\Seeder;

class JobSkillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_skills')->insert([
            ['skill_name'=>'Communication'],
            ['skill_name'=>'Teamwork'],
            ['skill_name'=>'Problem solving'],
            ['skill_name'=>'Initiative and enterprise'],
            ['skill_name'=>'Planning and organising'],
            ['skill_name'=>'Self-management'],
            ['skill_name'=>'Learning'],
            ['skill_name'=>'Technology']
        ]);
    }
}
