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
            $table->id();
            $table->timestamps();
            $table->bigInteger('team_id')->unsigned();
            $table->bigInteger('voucher_id')->unsigned();

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
