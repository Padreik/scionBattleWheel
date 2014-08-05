<?php

class Category extends Eloquent {
    public function battlewheel() {
        return $this->belongsTo('BattleWheel');
    }
    
    public function icons() {
        return $this->hasMany('Icon')->orderBy('name');
    }
}