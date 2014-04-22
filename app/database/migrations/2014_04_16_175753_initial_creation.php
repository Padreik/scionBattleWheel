<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialCreation extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function($table) {
            $table->increments('id');
            
            $table->string('email', 255);
            $table->string('password', 255);
            $table->string('remember_token');
            $table->string('confirmation');
            $table->boolean('confirmed')->default(0);
            
            $table->timestamps();
        });
        
        Schema::create('categories', function($table) {
            $table->increments('id');
            
            $table->integer('user_id')->references('id')->on('users');
            $table->string('name', 255);
            
            $table->timestamps();
        });
        
        Schema::create('icons', function($table) {
            $table->increments('id');
            
            $table->integer('category_id')->references('id')->on('categories');
            $table->string('name', 255);
            $table->binary('image');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users');
        Schema::drop('categories');
        Schema::drop('icons');
    }

}
