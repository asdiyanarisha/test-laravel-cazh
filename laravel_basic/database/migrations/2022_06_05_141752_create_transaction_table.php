<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->index('company_id');
            $table->foreignId('company_id')->references('id')->on('company');
            $table->index('employee_id');
            $table->foreignId('employee_id')->references('id')->on('employee');
            $table->integer('balance');
            $table->integer('company_start_balance');
            $table->integer('company_last_balance');
            $table->integer('employee_start_balance');
            $table->integer('employee_last_balance');
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
        Schema::dropIfExists('transaction');
    }
}
