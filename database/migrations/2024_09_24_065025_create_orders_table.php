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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('order_number');
            $table->string('receiver_name');
            $table->string('receiver_address');
            $table->enum('payment_method', ['Banking', 'Cash']);
            $table->enum('payment_status', ['pending', 'paid'])->default('pending');
            $table->enum('order_status', ['Wait For Approval', 'In Progress', 'Delivering', 'Delivered', 'Completed', 'Cancelled'])->default('Wait For Approval');
            $table->dateTime('date_created');
            $table->decimal('order_total', 8, 2)->default(0);
            $table->smallInteger('rate');
            $table->string('customer_feedback');
            $table->unsignedBigInteger('host_id'); //Id of customer who placed this order
            $table->unsignedBigInteger('manually_created_by');
            $table->enum('source', ['Offline', 'Online'])->default('Offline');
            $table->softDeletes();


            //Foreign Keys
            $table->foreign('host_id')->references('id')->on('customers');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
