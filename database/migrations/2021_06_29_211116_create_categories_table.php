<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     * $table->foreign('profession_id')->references('id')->on('professions');
     * $table->unsignedInteger('nombre_del_campo_aqui');
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cat_name', 50)->unique();
            $table->string('cat_img', 200)->nullable();
            $table->unsignedInteger('cat_userId');
            $table->foreign('cat_userId')->references('id')->on('users');
            $table->softDeletes();
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
        Schema::dropIfExists('categories');
    }
}
