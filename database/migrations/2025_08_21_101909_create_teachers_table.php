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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
             $table->string('first_name');
            $table->string('middle_name')->nullable();;
            $table->string('last_name')->nullable();
            $table->string('address')->nullable();
            $table->string('qualification')->nullable();
            $table->string('date_of_employement')->nullable();
            $table->enum('sex', ['male','female']);
            $table->string('dob')->nullable();
             $table->string('phone_no')->nullable();
  $table->enum('religion',['chritianity','islam','others'])->nullable();
            $table->string('national')->default('nigerian');
            $table->string('state_of_origin')->nullable();
            $table->string('previous_school_name')->nullable();
            $table->string('lga')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id')->references('id')->on('levels');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
             $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
