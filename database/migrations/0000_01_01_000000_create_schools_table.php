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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('address');
            $table->string('phone_no');
            $table->string('phone_no2')->nullable();
            $table->string('email');
            $table->date('date_of_establishment');
            $table->boolean('is_locked')->default(false);
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('school_logo')->nullable();
            $table->enum('type',['primary', 'secondary']);
          $table->string('proprietor')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
