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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('level_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('week_id');
            $table->foreign('week_id')->references('id')->on('attendance_weeks')->onDelete('cascade');
            $table->date('date');
            $table->enum('session', ['morning', 'afternoon']);
            $table->boolean('present')->default(false);
            $table->unsignedBigInteger('year_id');
            $table->unsignedBigInteger('school_id');
            $table->enum('term',['first','second','third']);
            $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
