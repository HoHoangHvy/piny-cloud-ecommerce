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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->uuid('id')->primary();;
            $table->timestamps();
            $table->string('vourcher_code');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('discount_type', ['percent', 'fixed'])->default('percent');
            $table->decimal('discount_amount', 8, 2)->default(0);
            $table->decimal('discount_percent', 8, 2)->default(0);
            $table->integer('limit');
            $table->json('config');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
