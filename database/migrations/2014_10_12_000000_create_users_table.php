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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('userType')->nullable();
            $table->string('branch')->nullable();
            $table->string('course')->nullable();
            $table->integer('phone')->nullable();
            $table->string('status')->nullable()->default('pending');
            $table->unsignedBigInteger('coach_id')->nullable(); // Change data type to match primary key of 'users' table
            $table->foreign('coach_id')->references('id')->on('users')->onDelete('cascade'); // Add foreign key constraint$table->string('coach_id')->nullable();
            $table->date('date_reserved')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
