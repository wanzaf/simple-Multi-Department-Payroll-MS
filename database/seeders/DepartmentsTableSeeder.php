<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('departments')->delete();
        
        DB::table('departments')->insert(array (
            0 => 
            array (
                'id' => 3,
                'name' => 'Human Resource',
                'created_at' => '2026-04-23 09:22:19',
                'updated_at' => '2026-04-23 09:36:11',
            ),
            1 => 
            array (
                'id' => 4,
                'name' => 'Finance',
                'created_at' => '2026-04-23 09:22:30',
                'updated_at' => '2026-04-23 10:35:13',
            ),
            2 => 
            array (
                'id' => 5,
                'name' => 'Engineering',
                'created_at' => '2026-04-23 13:24:04',
                'updated_at' => '2026-04-23 13:24:04',
            ),
            3 => 
            array (
                'id' => 6,
                'name' => 'Information Technology',
                'created_at' => '2026-04-24 10:35:42',
                'updated_at' => '2026-04-24 10:35:42',
            ),
            4 => 
            array (
                'id' => 7,
                'name' => 'Marketing',
                'created_at' => '2026-04-24 10:35:42',
                'updated_at' => '2026-04-24 10:35:42',
            ),
            5 => 
            array (
                'id' => 8,
                'name' => 'Sales',
                'created_at' => '2026-04-24 10:35:42',
                'updated_at' => '2026-04-24 10:35:42',
            ),
            6 => 
            array (
                'id' => 9,
                'name' => 'Operations',
                'created_at' => '2026-04-24 10:35:42',
                'updated_at' => '2026-04-24 10:35:42',
            ),
            7 => 
            array (
                'id' => 10,
                'name' => 'Research & Development',
                'created_at' => '2026-04-24 10:35:42',
                'updated_at' => '2026-04-24 10:35:42',
            ),
            8 => 
            array (
                'id' => 11,
                'name' => 'Customer Support',
                'created_at' => '2026-04-24 10:35:42',
                'updated_at' => '2026-04-24 10:35:42',
            ),
            9 => 
            array (
                'id' => 12,
                'name' => 'Legal',
                'created_at' => '2026-04-24 10:35:42',
                'updated_at' => '2026-04-24 10:35:42',
            ),
            10 => 
            array (
                'id' => 13,
                'name' => 'Administration',
                'created_at' => '2026-04-24 10:35:42',
                'updated_at' => '2026-04-24 10:35:42',
            ),
        ));
        
        
    }
}