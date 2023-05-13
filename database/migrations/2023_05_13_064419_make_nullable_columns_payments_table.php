<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeNullableColumnsPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school', function (Blueprint $table) {
            $table->longText('json_response')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('international')->nullable();
            $table->integer('amount_refunded')->default(0);
            $table->string('refund_status')->nullable();
            $table->boolean('captured')->nullable();
            $table->string('description')->nullable();
            $table->string('card_id')->nullable();
            $table->string('bank')->nullable();
            $table->string('wallet')->nullable();
            $table->string('vpa')->nullable();
            $table->string('contact')->nullable();
            $table->string('notes')->nullable();
            $table->string('fee')->nullable();
            $table->string('tax')->nullable();
            $table->string('error_code')->nullable();
            $table->string('error_description')->nullable();
            $table->string('error_source')->nullable();
            $table->string('error_step')->nullable();
            $table->string('error_reason')->nullable();
            $table->string('acquirer_data')->nullable();        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
