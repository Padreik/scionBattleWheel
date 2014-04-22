<?php

class Icon extends Eloquent {
    public function category() {
        return $this->belongsTo('Category');
    }
}