<?php

class UserController extends BaseController {
    
    public function create() {
        return View::make('user.create');
    }
    
    public function store() {
        $validationRules = array(
            'email' => 'required|email|unique:users|between:3,255',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password'
        );
        
        $validator = Validator::make(Input::all(), $validationRules);
        if ($validator->fails()) {
            Input::flashExcept('password', 'password_confirmation');
            return Redirect::action('UserController@create')->withErrors($validator);
        }
        else {
            $user = new User();
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->confirmation = str_random();
            $user->save();
            
            $data = array('confirmation' => $user->confirmation);
            Mail::queue('emails/auth/registration', $data, function($message) use ($user) {
                $message->to($user->email);
                $message->subject(Lang::get('auth.confirmation.title'));
                $message->from('noreply@pgirard.net');
            });
            return View::make('user.store');
        }
    }
}