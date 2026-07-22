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
       Schema::create('attachments', function (Blueprint $table) {

           $table->id('attachment_id');

    /*
     * الطلب المرتبط
     * الطلب الواحد يمكن أن يحتوي
     * على عدة ملفات
     */
           $table->foreignId('request_id')
                 ->constrained('requests','request_id')
                 ->onDelete('cascade');

    // اسم الملف
           $table->string('file_name');

    // مكان الملف داخل storage
           $table->string('file_path');

    // نوع الملف
           $table->string('file_type');

    // حجم الملف
         $table->bigInteger('file_size');

        $table->timestamps();
        $table->boolean('is_verified')
              ->default(false);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
