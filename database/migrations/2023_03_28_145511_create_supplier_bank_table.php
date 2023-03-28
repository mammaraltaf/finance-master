<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_bank', function (Blueprint $table) {
            $table->id('sb_id');
            $table->unsignedBigInteger('supplier_id');
            $table->integer('bank_id');
            $table->string('bank_name');
            $table->string('bank_account');
            $table->string('bank_swift');
            $table->string('accounting_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
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
        Schema::dropIfExists('supplier_bank');
    }
}
