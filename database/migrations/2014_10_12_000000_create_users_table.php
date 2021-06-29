<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('usr_name', 50);
            $table->string('usr_surname', 70)->nullable();
            $table->string('usr_role', 40);
            $table->string('usr_estate', 1)->default(1);
            $table->string('usr_email', 100)->unique();
            $table->string('usr_password', 200);
            $table->text('usr_img')->nullable();
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
        Schema::dropIfExists('users');
    }
}
