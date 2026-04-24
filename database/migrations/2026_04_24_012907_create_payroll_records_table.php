<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payroll_records', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('employee_id')->nullable();
            $table->tinyInteger('month')->nullable();
            $table->smallInteger('year')->nullable();
            $table->decimal('gross_pay', 10)->nullable();
            $table->decimal('overtime_pay', 10)->nullable();
            $table->decimal('tax', 10)->nullable();
            $table->decimal('epf_employee', 10)->nullable();
            $table->decimal('epf_employer', 10)->nullable();
            $table->decimal('net_pay', 10)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();

            $table->unique(['employee_id', 'month', 'year'], 'employee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_records');
    }
};
