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
        Schema::create('employees', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('department_id')->nullable()->index('fk_department');
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->decimal('basic_salary', 10)->nullable();
            $table->decimal('allowance', 10)->nullable();
            $table->integer('overtime_hours')->nullable();
            $table->decimal('hourly_rate', 10)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
