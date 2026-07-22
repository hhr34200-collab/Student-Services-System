<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE requests
            MODIFY status ENUM(
                'submitted',
                'student_affairs_review',
                'department_head_review',
                'dean_review',
                'archive_review',
                'approved',
                'returned_to_student',
                'returned_to_student_affairs',
                'returned_to_department_head',
                'rejected'
            ) NOT NULL DEFAULT 'submitted'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE requests
            MODIFY status ENUM(
                'submitted',
                'student_affairs_review',
                'department_head_review',
                'dean_review',
                'approved',
                'rejected'
            ) NOT NULL DEFAULT 'submitted'
        ");
    }
};