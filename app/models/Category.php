<?php

class Category extends Eloquent implements AccessibleInAdmin, HaveParent {
    public function battlewheel() {
        return $this->belongsTo('BattleWheel');
    }
    
    public function icons() {
        return $this->hasMany('Icon')->orderBy('name');
    }

    public function hasAccessInAdmin() {
        return $this->battlewheel->hasAccessInAdmin();
    }

    public function isParentIdValid($parentId) {
        return $parentId == $this->battlewheel_id;
    }

    public static function getParentClass() {
        return 'BattleWheel';
    }

}