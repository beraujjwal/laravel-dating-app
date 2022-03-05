<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->string('nickname')->nullable();
            $table->integer('age')->nullable();
            $table->string('image')->nullable();
            $table->string('marital_status')->nullable();
            $table->text('about_me')->nullable();
            $table->boolean('status');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
