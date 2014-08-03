<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBattlewheelTable extends Migration {

    public function up() {
        Schema::create('battlewheels', function($table) {
            $table->increments('id');
            
            $table->integer('user_id')->unsigned();
            $table->string('name', 255);
            $table->boolean('public');
            
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');
        });
        
        Schema::table('categories', function($table) {
            $table->integer('battlewheel_id')->unsigned()->after('user_id');
        });
        
        $categories = \Category::all();
        $userBattlewheelCombo = array();
        foreach ($categories as $category) {
            if (!isset($userBattlewheelCombo[$category->user_id])) {
                $newBattlewheel = new \Battlewheel();
                $newBattlewheel->user_id = $category->user_id;
                $newBattlewheel->name = "Default";
                $newBattlewheel->public = true;
                $newBattlewheel->save();
                $userBattlewheelCombo[$category->user_id] = $newBattlewheel->id;
            }
            $category->battlewheel_id = $userBattlewheelCombo[$category->user_id];
            $category->save();
        }
        
        Schema::table('categories', function($table) {
            $table->dropColumn('user_id');
            
            $table->foreign('battlewheel_id')->references('id')->on('battlewheels');
        });
    }

    public function down() {
        Schema::table('categories', function($table) {
            $table->integer('user_id')->unsigned()->after('battlewheel_id');
        });
        
        $categories = \Category::all();
        $battlewheelByUser = array();
        foreach ($categories as $category) {
            if (!isset($battlewheelByUser[$category->battlewheel_id])) {
                $battlewheel = \Battlewheel::find($category->battlewheel_id);
                $battlewheelByUser[$category->battlewheel_id] = $battlewheel->user_id;
            }
            $category->user_id = $battlewheelByUser[$category->battlewheel_id];
            $category->save();
        }
        
        Schema::table('categories', function($table) {
            $table->dropForeign('categories_battlewheel_id_foreign');
            $table->dropColumn('battlewheel_id');
        });
        
        Schema::drop('battlewheels');
    }

}
