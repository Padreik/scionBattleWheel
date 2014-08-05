<?php

interface HaveParent {
    public function isParentIdValid($parentId);
    public static function getParentClass();
}
