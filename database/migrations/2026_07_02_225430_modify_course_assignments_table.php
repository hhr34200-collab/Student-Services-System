<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_assignments', function (Blueprint $table) {

           
          
            $table->foreign('department_id')
                  ->references('id')
                  ->on('departments')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | منع تكرار نفس التوزيع
            |--------------------------------------------------------------------------
            */

            $table->unique(
                [
                    'course_id',
                    'department_id',
                    'employee_id',
                    'academic_year',
                    'semester'
                ],
                'course_assignment_unique'
            );

        });
    }

    public function down(): void
    {
        Schema::table('course_assignments', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | حذف المفتاح الفريد
            |--------------------------------------------------------------------------
            */

            $table->dropUnique('course_assignment_unique');

            /*
            |--------------------------------------------------------------------------
            | حذف المفتاح الأجنبي
            |--------------------------------------------------------------------------
            */

            $table->dropForeign(['department_id']);

            /*
            |--------------------------------------------------------------------------
            | حذف العمود
            |--------------------------------------------------------------------------
            */

            $table->dropColumn('department_id');

        });
    }
};