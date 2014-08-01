<?php

class BattleWheelController extends BaseController {
    
    public function show() {
        return View::make('battleWheel.show_new')->with('user', Auth::user());
    }
    
    public function showOther($user_id) {
        $user = User::find($user_id);
        if (is_object($user)) {
            return View::make('battleWheel.show')->with('user', $user);
        }
        else {
            return Redirect::to("/");
        }
    }
}