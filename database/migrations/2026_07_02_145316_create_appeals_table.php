<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appeals', function (Blueprint $table) {

            $table->id('appeal_id');

            $table->unsignedBigInteger('request_id')->unique();

            $table->string('academic_year');

            $table->enum('semester', [
                'first',
                'second'
            ]);

            $table->date('submission_date');

            $table->timestamps();

            $table->foreign('request_id')
                  ->references('request_id')
                  ->on('requests')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
};