<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        ));
        
        
    }
}