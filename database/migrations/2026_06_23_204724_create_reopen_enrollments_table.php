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
        Schema::create('reopen_enrollments', function (Blueprint $table) {

            $table->id('reopen_id');

            $table->unsignedBigInteger('request_id');

            $table->string('academic_year');

            $table->date('request_date');

            $table->timestamps();

            $table->foreign('request_id')
                  ->references('request_id')
                  ->on('requests')
                  ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reopen_enrollments');
    }
};