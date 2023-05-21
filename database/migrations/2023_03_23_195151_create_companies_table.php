<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('id_software')->unique();
            $table->string('tax_id')->unique();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->double('threshold_amount', 8, 2)->default(0);
            $table->string('bog')->nullable();
            $table->string('tbc')->nullable();
            $table->text('legal_address')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
