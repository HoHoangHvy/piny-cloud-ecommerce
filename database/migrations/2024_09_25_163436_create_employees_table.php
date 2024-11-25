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
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();;
            $table->timestamps();
            $table->uuid('user_id');
            $table->uuid('team_id');
            $table->dateTime('date_registered');
            $table->dateTime('date_of_birth');
            $table->string('full_name');
            $table->enum('gender', ['Male', 'Female']);
            $table->enum('level', ['Manager', 'Receptionist', 'Waiter']);
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->string('image')->nullable(); // Add this field for image

            //Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
