<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(DepartmentsTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(PayrollRecordsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
