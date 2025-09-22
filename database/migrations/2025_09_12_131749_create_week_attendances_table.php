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
        Schema::create('attendance_weeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('number'); // Week 1–13
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('term',['first','second','third']);
            $table->boolean('active')->default(true);
             $table->unsignedBigInteger('school_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('week_attendances');
    }
};
