<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->longText('pic')->nullable();
            $table->integer('level')->default(1); 
            $table->string('branch')->nullable();
            $table->integer('session')->nullable();
            $table->time('session_time')->nullable();
            $table->integer('age')->nullable();
            $table->string('course')->nullable();
            $table->integer('phone')->nullable();
            $table->string('status')->default('pending');
            // Add other student-specific columns as needed
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
