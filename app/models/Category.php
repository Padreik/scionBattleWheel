<?php

class Category extends Eloquent {
    public function user() {
        return $this->belongsTo('User');
    }
    
    public function icons() {
        return $this->hasMany('Icon')->orderBy('name');
    }
}