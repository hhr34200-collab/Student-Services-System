<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE notifications
            MODIFY COLUMN type ENUM(
                'submitted',
                'received',
                'approved',
                'rejected',
                'review',
                'warning'
            ) DEFAULT 'review'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE notifications
            MODIFY COLUMN type ENUM(
                'approved',
                'rejected',
                'review',
                'warning'
            ) DEFAULT 'review'
        ");
    }
};