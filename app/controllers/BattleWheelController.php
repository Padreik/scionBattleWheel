<?php

class BattleWheelController extends BaseController {
    
    public function index() {
        $user = Auth::user();
        return View::make('battleWheel.index')->with('battlewheels', $user->battlewheels);
    }
    
    public function show($id) {
        $battlewheel = \Battlewheel::find($id);
        return View::make('battleWheel.show')->with('battlewheel', $battlewheel);
    }
    
    public function displayDefault() {
        $user = Auth::user();
        $battleWheel = $user->battlewheels->first();
        return View::make('battleWheel.display')->with('battlewheel', $battleWheel);
    }
    
    public function display($id) {
        return View::make('battleWheel.display')->with('battlewheel', \Battlewheel::find($id));
    }
    
    public function displayOther($user_id) {
        $user = User::find($user_id);
        if (is_object($user)) {
            return View::make('battleWheel.display')->with('user', $user);
        }
        else {
            return Redirect::to("/");
        }
    }
}