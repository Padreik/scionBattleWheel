<?php

return array(
    'user' => 'user',
    'user.create' => 'user/create',
    
    'auth.confirmation' => 'authentification/confirmation',
    'auth.logout' => 'authentification/logout',
    'auth.login' => 'authentification/login',
    
    'battleWheel' => array(
        'index' => 'battlewheel',
        'create' => 'battlewheel/create',
        'store' => 'battlewheel',
        'show' => 'battlewheel/{id}',
        'edit' => 'battlewheel/{id}/edit',
        'update' => 'battlewheel/{id}',
        'destroy' => 'battlewheel/{id}'
    ),
    
    'category' => array(
        'index' => 'battlewheel/{parent_id}/category',
        'create' => 'battlewheel/{parent_id}/category/create',
        'store' => 'battlewheel/{parent_id}/category',
        'show' => 'battlewheel/{parent_id}/category/{id}',
        'edit' => 'battlewheel/{parent_id}/category/{id}/edit',
        'update' => 'battlewheel/{parent_id}/category/{id}',
        'destroy' => 'battlewheel/{parent_id}/category/{id}',
    ),
    
    'icon' => array(
        'index' => 'category/{parent_id}/icon',
        'create' => 'category/{parent_id}/icon/create',
        'store' => 'category/{parent_id}/icon',
        'image' => 'category/{parent_id}/icon/{id}/image',
        'edit' => 'category/{parent_id}/icon/{id}/edit',
        'update' => 'category/{parent_id}/icon/{id}',
        'destroy' => 'category/{parent_id}/icon/{id}',
    ),
);