<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pst_title', 50)->unique();
            $table->text('pst_content');
            $table->string('pst_img', 300)->nullable();
            $table->unsignedInteger('pst_userId');
            $table->foreign('pst_userId')->references('id')->on('users');
            $table->unsignedInteger('pst_cateId');
            $table->foreign('pst_cateId')->references('id')->on('categories');
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
        Schema::dropIfExists('posts');
    }
}
