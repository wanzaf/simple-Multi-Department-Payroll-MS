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
            3 => 
            array (
                'id' => 15,
                'department_id' => 3,
                'name' => 'Melor',
                'position' => 'Software Engineer',
                'basic_salary' => '5000.00',
                'allowance' => '500.00',
                'overtime_hours' => 5,
                'hourly_rate' => '25.00',
                'created_at' => '2026-04-24 10:44:14',
                'updated_at' => '2026-04-24 10:44:14',
            ),
            4 => 
            array (
                'id' => 16,
                'department_id' => 13,
                'name' => 'Nilam',
                'position' => 'Marketing Manager',
                'basic_salary' => '6000.00',
                'allowance' => '600.00',
                'overtime_hours' => 3,
                'hourly_rate' => '30.00',
                'created_at' => '2026-04-24 10:44:14',
                'updated_at' => '2026-04-24 10:44:14',
            ),
            5 => 
            array (
                'id' => 17,
                'department_id' => 3,
                'name' => 'Zamrud',
                'position' => 'Sales Executive',
                'basic_salary' => '4500.00',
                'allowance' => '400.00',
                'overtime_hours' => 8,
                'hourly_rate' => '22.50',
                'created_at' => '2026-04-24 10:44:14',
                'updated_at' => '2026-04-24 10:44:14',
            ),
            6 => 
            array (
                'id' => 18,
                'department_id' => 4,
                'name' => 'Belian',
                'position' => 'HR Specialist',
                'basic_salary' => '4800.00',
                'allowance' => '450.00',
                'overtime_hours' => 2,
                'hourly_rate' => '24.00',
                'created_at' => '2026-04-24 10:44:14',
                'updated_at' => '2026-04-24 10:44:14',
            ),
            7 => 
            array (
                'id' => 19,
                'department_id' => 5,
                'name' => 'Permata',
                'position' => 'Financial Analyst',
                'basic_salary' => '5500.00',
                'allowance' => '550.00',
                'overtime_hours' => 4,
                'hourly_rate' => '27.50',
                'created_at' => '2026-04-24 10:44:14',
                'updated_at' => '2026-04-24 10:44:14',
            ),
            8 => 
            array (
                'id' => 20,
                'department_id' => 6,
                'name' => 'Delima',
                'position' => 'Operations Coordinator',
                'basic_salary' => '4700.00',
                'allowance' => '420.00',
                'overtime_hours' => 6,
                'hourly_rate' => '23.50',
                'created_at' => '2026-04-24 10:44:14',
                'updated_at' => '2026-04-24 10:44:14',
            ),
            9 => 
            array (
                'id' => 21,
                'department_id' => 7,
                'name' => 'Biduri',
                'position' => 'R&D Scientist',
                'basic_salary' => '6200.00',
                'allowance' => '650.00',
                'overtime_hours' => 7,
                'hourly_rate' => '31.00',
                'created_at' => '2026-04-24 10:44:14',
                'updated_at' => '2026-04-24 10:44:14',
            ),
            10 => 
            array (
                'id' => 22,
                'department_id' => 8,
                'name' => 'Intan',
                'position' => 'Customer Support Lead',
                'basic_salary' => '4300.00',
                'allowance' => '380.00',
                'overtime_hours' => 10,
                'hourly_rate' => '21.50',
                'created_at' => '2026-04-24 10:44:14',
                'updated_at' => '2026-04-24 10:44:14',
            ),
            11 => 
            array (
                'id' => 23,
                'department_id' => 9,
                'name' => 'Mutiara',
                'position' => 'Legal Advisor',
                'basic_salary' => '7000.00',
                'allowance' => '800.00',
                'overtime_hours' => 2,
                'hourly_rate' => '35.00',
                'created_at' => '2026-04-24 10:44:14',
                'updated_at' => '2026-04-24 10:44:14',
            ),
            12 => 
            array (
                'id' => 24,
                'department_id' => 10,
                'name' => 'Baiduri',
                'position' => 'IT Administrator',
                'basic_salary' => '5200.00',
                'allowance' => '520.00',
                'overtime_hours' => 5,
                'hourly_rate' => '26.00',
                'created_at' => '2026-04-24 10:44:14',
                'updated_at' => '2026-04-24 10:44:14',
            ),
        ));
        
        
    }
}