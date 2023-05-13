<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('r_payment_id');
            $table->string('method');
            $table->string('currency');
            $table->string('user_email');
            $table->string('amount');
            $table->longText('json_response');
            $table->string('status');
            $table->string('order_id');
            $table->string('invoice_id');
            $table->string('international');
            $table->integer('amount_refunded')->default(0);
            $table->string('refund_status');
            $table->boolean('captured');
            $table->string('description');
            $table->string('card_id');
            $table->string('bank');
            $table->string('wallet');
            $table->string('vpa');
            $table->string('contact');
            $table->string('notes');
            $table->string('fee');
            $table->string('tax');
            $table->string('error_code');
            $table->string('error_description');
            $table->string('error_source');
            $table->string('error_step');
            $table->string('error_reason');
            $table->string('acquirer_data');
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
        Schema::dropIfExists('payments');
    }
}
