<?php

class Icon extends Eloquent implements AccessibleInAdmin, HaveParent {
    public function category() {
        return $this->belongsTo('Category');
    }

    public function hasAccessInAdmin() {
        return $this->category->hasAccessInAdmin();
    }

    public function isParentIdValid($parentId) {
        return $parentId == $this->category_id;
    }

    public static function getParentClass() {
        return 'Category';
    }

}