<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {

            // الطلب المرتبط بالإشعار
            $table->foreignId('request_id')
                  ->nullable()
                  ->after('user_id')
                  ->constrained('requests','request_id')
                  ->nullOnDelete();

            // رابط فتح الطلب مباشرة
            $table->string('action_url')
                  ->nullable()
                  ->after('type');

        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {

            $table->dropForeign(['request_id']);

            $table->dropColumn([
                'request_id',
                'action_url'
            ]);

        });
    }
};