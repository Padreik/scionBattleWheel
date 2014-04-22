<?php

return array(
    'user' => 'user',
    'user.create' => 'user/create',
    
    'auth.confirmation' => 'authentification/confirmation',
    'auth.logout' => 'authentification/logout',
    'auth.login' => 'authentification/login',
    
    'battleWheel' => array(
        'show' => 'battlewheel'
    ),
    
    'category' => array(
        'index' => 'category',
        'create' => 'category/create',
        'store' => 'category',
        'edit' => 'category/{category_id}/edit',
        'update' => 'category/{category_id}',
    ),
    
    'icon' => array(
        'index' => 'category/{category_id}/icon',
        'create' => 'category/{category_id}/icon/create',
        'store' => 'category/{category_id}/icon',
        'image' => 'category/{category_id}/icon/{icone_id}/image',
    ),
);