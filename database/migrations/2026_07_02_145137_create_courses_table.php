<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {

            $table->id('course_id');

            $table->string('course_name');

            $table->unsignedBigInteger('department_id');

            $table->enum('level', [
                'المستوى الأول',
                'المستوى الثاني',
                'المستوى الثالث',
                'المستوى الرابع'
            ]);

            $table->enum('semester', [
                'first',
                'second'
            ]);

            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            $table->timestamps();

            $table->foreign('department_id')
                  ->references('id')
                  ->on('departments')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};