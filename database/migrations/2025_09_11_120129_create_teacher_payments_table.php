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
        Schema::create('teacher_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('paid_by');
            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('year_id');
            $table->string('month');
            $table->string('description');
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
              $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');
              $table->foreign('paid_by')->references('id')->on('users')->onDelete('cascade');
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_payments');
    }
};
