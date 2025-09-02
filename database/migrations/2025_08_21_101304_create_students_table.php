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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
             $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('address')->nullable();
            $table->enum('sex', ['male','female']);
            $table->string('dob')->nullable();
             $table->string('lin_no')->nullable();
             $table->string('phone_no')->nullable();
             $table->enum('religion',['chritianity','islam','others'])->nullable();
            $table->string('national')->default('nigerian');
            $table->string('state_of_origin')->nullable();
            $table->string('previous_school_name')->nullable();
            $table->string('lga')->nullable();
            $table->string('avatar')->nullable();
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
        Schema::dropIfExists('students');
    }
};
