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
        Schema::create('lecture_students', function (Blueprint $table) {
            $table->id("lecture_students_id");
            $table->unsignedBigInteger("student_id");
            $table->unsignedBigInteger("lecture_id");
            $table->timestamps();
            
            $table->foreign("student_id")->references("student_id")->on("student")->onDelete('cascade');
            $table->foreign("lecture_id")->references("lecture_id")->on("lecture")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_students');
    }
};
