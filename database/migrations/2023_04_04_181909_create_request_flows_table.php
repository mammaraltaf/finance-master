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
            $table->string('initiator')->nullable(false);
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->foreignId('expense_type_id')->constrained('type_of_expanses')->onDelete('cascade');
            $table->string('currency')->nullable(false);
            $table->string('amount')->nullable(false);
            $table->string('description')->nullable(false);
            $table->string('basis')->nullable(false);
            $table->date('payment_date')->nullable(false);
            $table->date('submission_date')->nullable(false);
            $table->text('comment')->nullable();
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
