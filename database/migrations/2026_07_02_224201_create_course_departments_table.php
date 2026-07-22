<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_departments', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | المفتاح الأساسي
            |--------------------------------------------------------------------------
            */

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | المقرر
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('course_id');

            /*
            |--------------------------------------------------------------------------
            | القسم
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('department_id');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | علاقة المقرر
            |--------------------------------------------------------------------------
            */

            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | علاقة القسم
            |--------------------------------------------------------------------------
            */

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | منع تكرار نفس المقرر في نفس القسم
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'course_id',
                'department_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_departments');
    }
};