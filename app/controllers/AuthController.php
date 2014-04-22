<?php

class AuthController extends BaseController {
    
    public function login() {
        return View::make('auth.login');
    }
    
    public function connect() {
        $validationRules = array(
            'email' => 'required',
            'password' => 'required',
        );
        
        $validator = Validator::make(Input::all(), $validationRules);
        Input::flashExcept('password');
        if ($validator->fails()) {
            return Redirect::action('AuthController@login')->withErrors($validator);
        }
        else {
            $credentials = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );
            if (Auth::attempt($credentials)) {
                return Redirect::to('/');
            }
            else {
                return Redirect::action('AuthController@login')->with('login_error', '1');
            }
        }
    }
    
    public function confirmation($key) {
        $user = User::where('confirmation', '=', $key)->where('confirmed', '=', '0')->first();
        if (!is_null($user)) {
            $user->confirmation = '';
            $user->confirmed = 1;
            $user->save();
            Auth::login($user);
        }
        return View::make('auth.confirmation')->with('success', !is_null($user));
    }
    
    public function logout() {
        Auth::logout();
        return Redirect::to('/');
    }
}