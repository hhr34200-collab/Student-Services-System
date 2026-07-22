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
        Schema::create('stop_enrollments', function (Blueprint $table) {

            $table->id();

             /*
             * الطلب المرتبط
             * علاقة One To One
             */
            $table->foreignId('request_id')
                  ->unique()
                  ->constrained('requests','request_id')
                  ->onDelete('cascade');

             // العام الجامعي
            $table->string('academic_year');

             // الفصل الدراسي
            $table->enum('semester',['first', 'second']);
            $table->enum('stop_period',[ 'semester',  'academic_year']);


    // سبب وقف القيد
            $table->text('reason');

            $table->timestamps();
            

           $table->integer('previous_stop_count')->default(0);

           $table->date('request_date');
});        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stop_enrollments');
    }
};
