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
            $table->foreignId('restaurant_id')->constrained();
            $table->foreignId('cashier_id')->nullable()->constrained('users');
            $table->string('invoice_number', 50)->unique();
            $table->string('order_type', 20)->default('dine_in');
            $table->foreignId('table_id')->nullable()->constrained('cafe_tables');
            $table->timestamp('order_time');
            $table->string('customer_name', 50)->nullable();
            $table->string('customer_contact_number', 15)->nullable();
            $table->integer('subtotal');
            $table->integer('tax')->default(0);
            $table->integer('service_charge')->default(0);
            $table->integer('total_amount');
            $table->string('payment_status', 20)->default('unpaid');
            $table->string('order_status', 20)->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
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
