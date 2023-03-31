<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_flows', function (Blueprint $table) {
            $table->id();
            $table->integer('initiator')->nullable(false);
            $table->integer('company')->nullable(false);
            $table->integer('department')->nullable(false);
            $table->integer('supplier')->nullable(false);
            $table->string('expense_type')->nullable(false);
            $table->string('currency')->nullable(false);
            $table->string('amount')->nullable(false);
            $table->string('description')->nullable(false);
            $table->string('basis')->nullable(false);
            $table->date('payment_date')->nullable(false);
            $table->date('submission_date')->nullable(false);
            $table->string('status')->nullable(false);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('request_flows');
    }
}
