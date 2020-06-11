<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('budget_id')->unsigned();
            $table->foreign('budget_id')->references('id')->on('budgets');
            $table->integer('category_id')->unsigned();
            //$table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('category_id')->references('id')->on('event_types');
            $table->integer('number_forming')->nullable();
            $table->integer('invitations_by_forming')->nullable();
            $table->integer('extra_invitations')->nullable();
            $table->decimal('extra_invitations_value',8, 2)->nullable();
            $table->integer('extra_tables')->nullable();
            $table->decimal('extra_tables_value', 8, 2)->nullable();
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
        Schema::dropIfExists('budget_categories');
    }
}
