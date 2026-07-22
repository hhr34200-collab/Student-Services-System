<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {

            $table->enum(
                'academic_status',
                [
                    'active',
                    'stopped',
                    'graduated',
                    'dismissed',
                    'withdrawn'
                ]
            )->default('active')
             ->after('level');

        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {

            $table->dropColumn('academic_status');

        });
    }
};