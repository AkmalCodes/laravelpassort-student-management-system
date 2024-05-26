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
        Schema::create('lecture', function (Blueprint $table) {
            $table->id('lecture_id');
            $table->string('lecture_day');
            $table->integer('lecture_duration_hours');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('lecturer_id');
            $table->timestamps();

            $table->foreign('course_id')->references('course_id')->on('course')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture');
    }
};
