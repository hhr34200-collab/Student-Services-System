<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {

            $table->id('student_id');

            $table->string('student_number')->unique();

            $table->string('full_name');

            $table->foreignId('college_id')
                  ->constrained('colleges')
                  ->onDelete('cascade');

            $table->foreignId('department_id')
                  ->constrained('departments')
                  ->onDelete('cascade');

            $table->string('level');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};