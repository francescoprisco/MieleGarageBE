<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_option_id')->constrained()->cascadeOnDelete();
            $table->foreignId('delivery_address_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->double('total_amount', 8, 2);
            $table->double('sub_total_amount', 8, 2);
            $table->double('delivery_fee', 8, 2);
            $table->enum('status', ["pending","preparing","ready","enroute","delivered","failed","cancelled"])->default('pending');
            $table->enum('payment_status', ["pending","successful","failed"])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
