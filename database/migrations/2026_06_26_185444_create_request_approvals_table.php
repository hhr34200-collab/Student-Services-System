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
        Schema::create('request_approvals', function (Blueprint $table) {

            // المفتاح الأساسي
            $table->id('approval_id');

            // الطلب
           $table->unsignedBigInteger('request_id');

           $table->foreign('request_id')
           ->references('request_id')
           ->on('requests')
           ->cascadeOnDelete();

            // الموظف الذي كتب الإفادة
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->cascadeOnDelete();

            // المرحلة الحالية
            $table->enum('stage', [
                'student_affairs',
                'department_head',
                'dean',
                'archive'
            ]);

        // نص الإفادة
      $table->text('approval_text');

// هل تم قفل الإفادة بعد الحفظ؟
         $table->boolean('is_locked')->default(false);

// حالة الإفادة
       $table->enum('approval_status', [
    'saved',
    'forwarded',
    'approved',
    'rejected',
    'archived'
])->default('saved');

            // تاريخ الحفظ
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_approvals');
    }
};