<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'payroll_records';

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'gross_pay',
        'overtime_pay',
        'tax',
        'epf_employee',
        'epf_employer',
        'net_pay',
    ];

    protected $casts = [
        'month'        => 'integer',
        'year'         => 'integer',
        'gross_pay'    => 'decimal:2',
        'overtime_pay' => 'decimal:2',
        'tax'          => 'decimal:2',
        'epf_employee' => 'decimal:2',
        'epf_employer' => 'decimal:2',
        'net_pay'      => 'decimal:2',
    ];

    // Variables
    const TAX_RATE          = 0.08;
    const EPF_EMPLOYEE_RATE = 0.11;
    const EPF_EMPLOYER_RATE = 0.13;

    // Hubungan
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public static function calculateOvertimePay(float $overtimeHours, float $hourlyRate): float
    {
        return $overtimeHours * $hourlyRate;
    }

    public static function calculateGrossPay(float $basicSalary, float $allowance, float $overtimePay): float
    {
        return $basicSalary + $allowance + $overtimePay;
    }

    public static function calculateTax(float $grossPay): float
    {
        return $grossPay * self::TAX_RATE;
    }

    public static function calculateEpfEmployee(float $grossPay): float
    {
        return $grossPay * self::EPF_EMPLOYEE_RATE;
    }

    public static function calculateEpfEmployer(float $grossPay): float
    {
        return $grossPay * self::EPF_EMPLOYER_RATE;
    }

    public static function calculateNetPay(float $grossPay, float $tax, float $epfEmployee): float
    {
        return $grossPay - $tax - $epfEmployee;
    }

    public static function computeFromEmployee(Employee $employee): array
    {
        $overtimePay = self::calculateOvertimePay($employee->overtime_hours, $employee->hourly_rate);
        $grossPay    = self::calculateGrossPay($employee->basic_salary, $employee->allowance, $overtimePay);
        $tax         = self::calculateTax($grossPay);
        $epfEmployee = self::calculateEpfEmployee($grossPay);
        $epfEmployer = self::calculateEpfEmployer($grossPay);
        $netPay      = self::calculateNetPay($grossPay, $tax, $epfEmployee);

        return [
            'overtime_pay' => round($overtimePay, 2),
            'gross_pay'    => round($grossPay, 2),
            'tax'          => round($tax, 2),
            'epf_employee' => round($epfEmployee, 2),
            'epf_employer' => round($epfEmployer, 2),
            'net_pay'      => round($netPay, 2),
        ];
    }
}
