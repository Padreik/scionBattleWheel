<?php

return array(
    'user' => 'utilisateur',
    'user.create' => 'utilisateur/creer',
    
    'auth.confirmation' => 'authentification/confirmation',
    'auth.logout' => 'authentification/deconnexion',
    'auth.login' => 'authentification/connexion',
    
    'battleWheel' => array(
        'show' => 'battlewheel'
    ),
    
    'category' => array(
        'index' => 'categorie',
        'create' => 'categorie/creer',
        'store' => 'categorie',
    ),
    
    'icon' => array(
        'index' => 'categorie/{category_id}/icone',
        'create' => 'categorie/{category_id}/icone/creer',
        'store' => 'categorie/{category_id}/icone',
        'image' => 'categorie/{category_id}/icone/{icone_id}/image',
    ),
);