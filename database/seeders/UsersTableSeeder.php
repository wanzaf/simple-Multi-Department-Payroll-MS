<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('users')->delete();
        
        DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Dev',
                'email' => 'wannaqib01@gmail.com',
                'password' => '$2y$12$wF0bal7Wu1k.VDW0PaRX7.LBRpeMiz3PCctcQGX/p75bI7RS/zbj2',
                'created_at' => '2026-04-23 07:44:26',
                'updated_at' => '2026-04-23 18:12:42',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'test',
                'email' => 'test@larabel.com.my',
                'password' => '$2y$12$0sqPUEoHot3aWM2X8Ph0yO8GX0m8/atYJjqlEEy9Qj/kJPYQk2Pra',
                'created_at' => '2026-04-23 13:11:09',
                'updated_at' => '2026-04-23 13:11:09',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '011203030191',
                'email' => 'wannaqib011@gmail.com',
                'password' => '$2y$12$jCpEaQ4FQMAdX6JxLaZh8e2RIDpfvPe60APCinMGxMdgJuol9iLLu',
                'created_at' => '2026-04-23 15:42:28',
                'updated_at' => '2026-04-23 15:42:28',
            ),
        ));
        
        
    }
}