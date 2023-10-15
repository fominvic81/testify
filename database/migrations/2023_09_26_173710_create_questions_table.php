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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->string('image')->nullable();
            $table->integer('type');
            $table->integer('points');
            $table->text('explanation')->nullable();
            $table->foreignId('test_id');
            $table->boolean('register_matters')->default(false);
            $table->boolean('whitespace_matters')->default(false);
            $table->boolean('show_amount_of_correct')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question');
    }
};