<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies_users', function (Blueprint $table) {
            $table->id();
           
                $table->unsignedBiginteger('companies_id')->unsigned();
                $table->unsignedBiginteger('users_id')->unsigned();
    
                $table->foreign('companies_id')->references('id')
                     ->on('companies')->onDelete('cascade');
                $table->foreign('users_id')->references('id')
                    ->on('users')->onDelete('cascade');
    

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
        Schema::dropIfExists('companies_users');
    }
}
