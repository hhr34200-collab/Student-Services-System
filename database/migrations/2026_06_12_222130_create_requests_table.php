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
        Schema::create('requests', function (Blueprint $table) {

         // المفتاح الأساسي
            $table->id('request_id');

          /*
            * الطالب صاحب الطلب
            * علاقة Many To One
           */
            $table->foreignId('student_id')
                  ->constrained('students','student_id')
                  ->onDelete('cascade');

         /*
     * الخدمة المطلوبة
     * علاقة Many To One
     */
            $table->foreignId('service_id')
                  ->constrained('services','service_id')
                  ->onDelete('cascade');

    // حالة الطلب
            $table->enum('status',[
                         'submitted',
                         'student_affairs_review',
                         'department_head_review',
                         'dean_review',
                         'approved',
                         'rejected'
                 ])->default('submitted');
            
    // ملاحظات الموظف
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
