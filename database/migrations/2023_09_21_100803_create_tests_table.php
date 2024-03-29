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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('published')->default(false)->index();
            $table->integer('accessibility')->unsigned()->index();
            $table->foreignId('user_id');
            $table->foreignId('course_id')->nullable();
            $table->foreignId('subject_id')->nullable();
            $table->foreignId('grade_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
