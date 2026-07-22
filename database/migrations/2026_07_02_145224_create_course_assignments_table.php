<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_assignments', function (Blueprint $table) {

            $table->id('assignment_id');

            $table->unsignedBigInteger('course_id');

            $table->unsignedBigInteger('employee_id');

            $table->string('academic_year');

            $table->enum('semester', [
                'first',
                'second'
            ]);

            $table->timestamps();

            $table->foreign('course_id')
                  ->references('course_id')
                  ->on('courses')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreign('employee_id')
                  ->references('employee_id')
                  ->on('employees')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_assignments');
    }
};