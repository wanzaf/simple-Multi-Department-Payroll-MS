<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('employees')->delete();
        
        DB::table('employees')->insert(array (
            0 => 
            array (
                'id' => 2,
                'department_id' => 3,
                'name' => 'Wan Muhammad Naqib Zafran',
                'position' => 'SWE',
                'basic_salary' => '1700.00',
                'allowance' => '1400.00',
                'overtime_hours' => 25,
                'hourly_rate' => '23.00',
                'created_at' => '2026-04-23 10:29:15',
                'updated_at' => '2026-04-23 13:15:19',
            ),
            1 => 
            array (
                'id' => 3,
                'department_id' => 3,
                'name' => 'Freddy Mercury',
                'position' => 'Penolong',
                'basic_salary' => '4000.00',
                'allowance' => '300.00',
                'overtime_hours' => 30,
                'hourly_rate' => '50.00',
                'created_at' => '2026-04-23 10:30:08',
                'updated_at' => '2026-04-23 10:30:08',
            ),
            2 => 
            array (
                'id' => 4,
                'department_id' => 5,
                'name' => 'Siti Aminah',
                'position' => 'Chief Everything Officer',
                'basic_salary' => '4000.00',
                'allowance' => '600.00',
                'overtime_hours' => 10,
                'hourly_rate' => '25.00',
                'created_at' => '2026-04-23 13:22:42',
                'updated_at' => '2026-04-23 13:24:13',
            ),
        ));
        
        
    }
}