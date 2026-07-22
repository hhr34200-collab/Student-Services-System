<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | حذف المفتاح الأجنبي أولاً
        |--------------------------------------------------------------------------
        */

        Schema::table('courses', function (Blueprint $table) {

            $table->dropForeign(['department_id']);

        });

        /*
        |--------------------------------------------------------------------------
        | حذف الحقل
        |--------------------------------------------------------------------------
        */

        Schema::table('courses', function (Blueprint $table) {

            $table->dropColumn('department_id');

        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {

            $table->unsignedBigInteger('department_id');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

        });
    }
};