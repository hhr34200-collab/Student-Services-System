<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {

            $table->id();

    // رقم الطالب
            $table->foreignId('student_id')
                  ->constrained('students','student_id')
                  ->onDelete('cascade');

    // عنوان الإشعار
            $table->string('title');

    // نص الإشعار
            $table->text('message');

    // هل تمت قراءته؟
            $table->boolean('is_read')
                  ->default(false);

            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
