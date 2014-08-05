<?php

class Battlewheel extends Eloquent implements AccessibleInAdmin {
    public function user() {
        return $this->belongsTo('User');
    }
    
    public function categories() {
        return $this->hasMany('Category')->orderBy('name');
    }

    public function hasAccessInAdmin() {
        if (!Auth::check()) {
            return false;
        }
        $currentUser = Auth::user();
        return $this->user_id == $currentUser->id;
    }

}