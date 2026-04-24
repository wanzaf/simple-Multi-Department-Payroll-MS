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
                'gross_pay' => '4940.00',
                'overtime_pay' => '1840.00',
                'tax' => '395.20',
                'epf_employee' => '543.40',
                'epf_employer' => '642.20',
                'net_pay' => '4001.40',
                'created_at' => '2026-04-23 14:33:33',
                'updated_at' => '2026-04-24 03:21:52',
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
            12 => 
            array (
                'id' => 13,
                'employee_id' => 15,
                'month' => 4,
                'year' => 2026,
                'gross_pay' => '5625.00',
                'overtime_pay' => '125.00',
                'tax' => '450.00',
                'epf_employee' => '618.75',
                'epf_employer' => '731.25',
                'net_pay' => '4556.25',
                'created_at' => '2026-04-24 03:21:51',
                'updated_at' => '2026-04-24 03:21:51',
            ),
            13 => 
            array (
                'id' => 14,
                'employee_id' => 16,
                'month' => 4,
                'year' => 2026,
                'gross_pay' => '6690.00',
                'overtime_pay' => '90.00',
                'tax' => '535.20',
                'epf_employee' => '735.90',
                'epf_employer' => '869.70',
                'net_pay' => '5418.90',
                'created_at' => '2026-04-24 03:21:51',
                'updated_at' => '2026-04-24 03:21:51',
            ),
            14 => 
            array (
                'id' => 15,
                'employee_id' => 17,
                'month' => 4,
                'year' => 2026,
                'gross_pay' => '5080.00',
                'overtime_pay' => '180.00',
                'tax' => '406.40',
                'epf_employee' => '558.80',
                'epf_employer' => '660.40',
                'net_pay' => '4114.80',
                'created_at' => '2026-04-24 03:21:51',
                'updated_at' => '2026-04-24 03:21:51',
            ),
            15 => 
            array (
                'id' => 16,
                'employee_id' => 18,
                'month' => 4,
                'year' => 2026,
                'gross_pay' => '5298.00',
                'overtime_pay' => '48.00',
                'tax' => '423.84',
                'epf_employee' => '582.78',
                'epf_employer' => '688.74',
                'net_pay' => '4291.38',
                'created_at' => '2026-04-24 03:21:51',
                'updated_at' => '2026-04-24 03:21:51',
            ),
            16 => 
            array (
                'id' => 17,
                'employee_id' => 19,
                'month' => 4,
                'year' => 2026,
                'gross_pay' => '6160.00',
                'overtime_pay' => '110.00',
                'tax' => '492.80',
                'epf_employee' => '677.60',
                'epf_employer' => '800.80',
                'net_pay' => '4989.60',
                'created_at' => '2026-04-24 03:21:51',
                'updated_at' => '2026-04-24 03:21:51',
            ),
            17 => 
            array (
                'id' => 18,
                'employee_id' => 20,
                'month' => 4,
                'year' => 2026,
                'gross_pay' => '5261.00',
                'overtime_pay' => '141.00',
                'tax' => '420.88',
                'epf_employee' => '578.71',
                'epf_employer' => '683.93',
                'net_pay' => '4261.41',
                'created_at' => '2026-04-24 03:21:51',
                'updated_at' => '2026-04-24 03:21:51',
            ),
            18 => 
            array (
                'id' => 19,
                'employee_id' => 21,
                'month' => 4,
                'year' => 2026,
                'gross_pay' => '7067.00',
                'overtime_pay' => '217.00',
                'tax' => '565.36',
                'epf_employee' => '777.37',
                'epf_employer' => '918.71',
                'net_pay' => '5724.27',
                'created_at' => '2026-04-24 03:21:51',
                'updated_at' => '2026-04-24 03:21:51',
            ),
            19 => 
            array (
                'id' => 20,
                'employee_id' => 22,
                'month' => 4,
                'year' => 2026,
                'gross_pay' => '4895.00',
                'overtime_pay' => '215.00',
                'tax' => '391.60',
                'epf_employee' => '538.45',
                'epf_employer' => '636.35',
                'net_pay' => '3964.95',
                'created_at' => '2026-04-24 03:21:51',
                'updated_at' => '2026-04-24 03:21:51',
            ),
            20 => 
            array (
                'id' => 21,
                'employee_id' => 23,
                'month' => 4,
                'year' => 2026,
                'gross_pay' => '7870.00',
                'overtime_pay' => '70.00',
                'tax' => '629.60',
                'epf_employee' => '865.70',
                'epf_employer' => '1023.10',
                'net_pay' => '6374.70',
                'created_at' => '2026-04-24 03:21:51',
                'updated_at' => '2026-04-24 03:21:51',
            ),
            21 => 
            array (
                'id' => 22,
                'employee_id' => 24,
                'month' => 4,
                'year' => 2026,
                'gross_pay' => '5850.00',
                'overtime_pay' => '130.00',
                'tax' => '468.00',
                'epf_employee' => '643.50',
                'epf_employer' => '760.50',
                'net_pay' => '4738.50',
                'created_at' => '2026-04-24 03:21:52',
                'updated_at' => '2026-04-24 03:21:52',
            ),
        ));
        
        
    }
}