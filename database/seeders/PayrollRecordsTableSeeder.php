<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PayrollRecordsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('payroll_records')->delete();
        
        DB::table('payroll_records')->insert(array (
            0 => 
            array (
                'id' => 1,
                'employee_id' => 4,
                'month' => 4,
                'year' => 2026,
                'gross_pay' => '4850.00',
                'overtime_pay' => '250.00',
                'tax' => '388.00',
                'epf_employee' => '533.50',
                'epf_employer' => '630.50',
                'net_pay' => '3928.50',
                'created_at' => '2026-04-23 14:33:33',
                'updated_at' => '2026-04-23 14:34:57',
            ),
            1 => 
            array (
                'id' => 2,
                'employee_id' => 3,
                'month' => 4,
                'year' => 2026,
                'gross_pay' => '5800.00',
                'overtime_pay' => '1500.00',
                'tax' => '464.00',
                'epf_employee' => '638.00',
                'epf_employer' => '754.00',
                'net_pay' => '4698.00',
                'created_at' => '2026-04-23 14:33:33',
                'updated_at' => '2026-04-23 14:33:33',
            ),
            2 => 
            array (
                'id' => 3,
                'employee_id' => 2,
                'month' => 4,
                'year' => 2026,
                'gross_pay' => '3675.00',
                'overtime_pay' => '575.00',
                'tax' => '294.00',
                'epf_employee' => '404.25',
                'epf_employer' => '477.75',
                'net_pay' => '2976.75',
                'created_at' => '2026-04-23 14:33:33',
                'updated_at' => '2026-04-23 14:33:33',
            ),
            3 => 
            array (
                'id' => 4,
                'employee_id' => 4,
                'month' => 3,
                'year' => 2026,
                'gross_pay' => '4850.00',
                'overtime_pay' => '250.00',
                'tax' => '388.00',
                'epf_employee' => '533.50',
                'epf_employer' => '630.50',
                'net_pay' => '3928.50',
                'created_at' => '2026-04-23 14:51:28',
                'updated_at' => '2026-04-23 14:51:28',
            ),
            4 => 
            array (
                'id' => 5,
                'employee_id' => 3,
                'month' => 3,
                'year' => 2026,
                'gross_pay' => '5800.00',
                'overtime_pay' => '1500.00',
                'tax' => '464.00',
                'epf_employee' => '638.00',
                'epf_employer' => '754.00',
                'net_pay' => '4698.00',
                'created_at' => '2026-04-23 14:51:28',
                'updated_at' => '2026-04-23 14:51:28',
            ),
            5 => 
            array (
                'id' => 6,
                'employee_id' => 2,
                'month' => 3,
                'year' => 2026,
                'gross_pay' => '3675.00',
                'overtime_pay' => '575.00',
                'tax' => '294.00',
                'epf_employee' => '404.25',
                'epf_employer' => '477.75',
                'net_pay' => '2976.75',
                'created_at' => '2026-04-23 14:51:28',
                'updated_at' => '2026-04-23 14:51:28',
            ),
            6 => 
            array (
                'id' => 7,
                'employee_id' => 4,
                'month' => 2,
                'year' => 2026,
                'gross_pay' => '4850.00',
                'overtime_pay' => '250.00',
                'tax' => '388.00',
                'epf_employee' => '533.50',
                'epf_employer' => '630.50',
                'net_pay' => '3928.50',
                'created_at' => '2026-04-23 14:52:43',
                'updated_at' => '2026-04-23 14:52:43',
            ),
            7 => 
            array (
                'id' => 8,
                'employee_id' => 3,
                'month' => 2,
                'year' => 2026,
                'gross_pay' => '5800.00',
                'overtime_pay' => '1500.00',
                'tax' => '464.00',
                'epf_employee' => '638.00',
                'epf_employer' => '754.00',
                'net_pay' => '4698.00',
                'created_at' => '2026-04-23 14:52:43',
                'updated_at' => '2026-04-23 14:52:43',
            ),
            8 => 
            array (
                'id' => 9,
                'employee_id' => 2,
                'month' => 2,
                'year' => 2026,
                'gross_pay' => '3675.00',
                'overtime_pay' => '575.00',
                'tax' => '294.00',
                'epf_employee' => '404.25',
                'epf_employer' => '477.75',
                'net_pay' => '2976.75',
                'created_at' => '2026-04-23 14:52:43',
                'updated_at' => '2026-04-23 14:52:43',
            ),
            9 => 
            array (
                'id' => 10,
                'employee_id' => 4,
                'month' => 1,
                'year' => 2026,
                'gross_pay' => '4850.00',
                'overtime_pay' => '250.00',
                'tax' => '388.00',
                'epf_employee' => '533.50',
                'epf_employer' => '630.50',
                'net_pay' => '3928.50',
                'created_at' => '2026-04-23 14:52:45',
                'updated_at' => '2026-04-23 14:52:45',
            ),
            10 => 
            array (
                'id' => 11,
                'employee_id' => 3,
                'month' => 1,
                'year' => 2026,
                'gross_pay' => '5800.00',
                'overtime_pay' => '1500.00',
                'tax' => '464.00',
                'epf_employee' => '638.00',
                'epf_employer' => '754.00',
                'net_pay' => '4698.00',
                'created_at' => '2026-04-23 14:52:45',
                'updated_at' => '2026-04-23 14:52:45',
            ),
            11 => 
            array (
                'id' => 12,
                'employee_id' => 2,
                'month' => 1,
                'year' => 2026,
                'gross_pay' => '3675.00',
                'overtime_pay' => '575.00',
                'tax' => '294.00',
                'epf_employee' => '404.25',
                'epf_employer' => '477.75',
                'net_pay' => '2976.75',
                'created_at' => '2026-04-23 14:52:45',
                'updated_at' => '2026-04-23 14:52:45',
            ),
        ));
        
        
    }
}