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
        Schema::create('teams_vouchers', function (Blueprint $table) {
            $table->uuid('id')->primary();;
            $table->timestamps();
            $table->uuid('team_id');
            $table->uuid('voucher_id');

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams_vouchers');
    }
};
