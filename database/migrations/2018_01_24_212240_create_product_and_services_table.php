<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAndServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_and_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->decimal('price');
            $table->decimal('cost_price');
            $table->decimal('minimum_price');
            $table->text('description');
            $table->integer('position');
            $table->integer('proportion_per_person');
            $table->tinyInteger('multiplying_graduates');
            $table->tinyInteger('multiplied_invitations');
            $table->tinyInteger('extras_invitations');
            $table->tinyInteger('extras_tables');
            $table->integer('alias')->default(0);
            $table->text('comments')->nullable();
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
        Schema::dropIfExists('product_and_services');
    }
}
