<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            // حذف الربط القديم
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // حذف القسم النصي
            $table->dropColumn('department');

            // الاسم الكامل
            $table->string('full_name')->after('employee_number');

            // الكلية
            $table->foreignId('college_id')
                  ->after('full_name')
                  ->constrained('colleges')
                  ->cascadeOnDelete();

            // القسم
            $table->foreignId('department_id')
                  ->after('college_id')
                  ->constrained('departments')
                  ->cascadeOnDelete();
        });

        // تغيير اسم المفتاح الأساسي
        DB::statement('ALTER TABLE employees CHANGE id employee_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE employees CHANGE employee_id id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');

        Schema::table('employees', function (Blueprint $table) {

            $table->dropForeign(['college_id']);
            $table->dropForeign(['department_id']);

            $table->dropColumn([
                'full_name',
                'college_id',
                'department_id'
            ]);

            $table->string('department');

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
        });
    }
};