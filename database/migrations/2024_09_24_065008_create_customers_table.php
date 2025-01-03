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
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();;
            $table->timestamps();
            $table->uuid('user_id');
            $table->dateTime('date_registered');
            $table->dateTime('date_of_birth');
            $table->string('full_name');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->softDeletes();
            $table->uuid('team_id');
            $table->uuid('created_by');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            //Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
