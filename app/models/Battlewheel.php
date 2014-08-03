<?php

class Battlewheel extends Eloquent {
    public function user() {
        return $this->belongsTo('User');
    }
    
    public function categories() {
        return $this->hasMany('Category')->orderBy('name');
    }
}