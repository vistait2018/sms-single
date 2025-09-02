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
        Schema::create('level_student', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('student_id');
             $table->unsignedBigInteger('year_id');
              $table->unsignedBigInteger('level_id');
            $table->boolean('active')->default(true);
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_students');
    }
};
