<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appeal_items', function (Blueprint $table) {

            $table->id('item_id');

            $table->unsignedBigInteger('appeal_id');

            $table->unsignedBigInteger('course_id');

            $table->text('reason');

            $table->timestamps();

            $table->foreign('appeal_id')
                  ->references('appeal_id')
                  ->on('appeals')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreign('course_id')
                  ->references('course_id')
                  ->on('courses')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appeal_items');
    }
};