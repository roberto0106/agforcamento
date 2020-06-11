<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->string('name');
            $table->integer('number_of_installments');
            $table->decimal('fee');
            $table->decimal('photo_exclusivity');
            $table->date('shelf_life');
            $table->text('internal_comment')->nullable();
            $table->text('external_comment')->nullable();
            $table->decimal('paying_commission')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->string('token_access')->nullable();
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
        Schema::dropIfExists('budgets');
    }
}
