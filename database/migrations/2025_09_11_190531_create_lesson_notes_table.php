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
        Schema::create('lesson_notes', function (Blueprint $table) {
            $table->id();
           $table->unsignedBigInteger('written_by_id');
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('school_id');
            $table->string('note_url');
            $table->enum('term',['first','second','third']);
            $table->enum('week',['1','2','3','4','5','6','7','8','9','10']);
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->unsignedBigInteger('year_id');
$table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');

            $table->foreign('written_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_notes');
    }
};
