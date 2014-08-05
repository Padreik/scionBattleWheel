<?php

return array(
    'user' => 'utilisateur',
    'user.create' => 'utilisateur/creer',
    
    'auth.confirmation' => 'authentification/confirmation',
    'auth.logout' => 'authentification/deconnexion',
    'auth.login' => 'authentification/connexion',
    
    'battleWheel' => array(
        'index' => 'battlewheel',
        'create' => 'battlewheel/creer',
        'store' => 'battlewheel',
        'show' => 'battlewheel/{id}',
        'edit' => 'battlewheel/{id}/modifier',
        'update' => 'battlewheel/{id}',
        'destroy' => 'battlewheel/{id}'
    ),
    
    'category' => array(
        'index' => 'battlewheel/{parent_id}/categorie',
        'create' => 'battlewheel/{parent_id}/categorie/creer',
        'store' => 'battlewheel/{parent_id}/categorie',
        'show' => 'battlewheel/{parent_id}/categorie/{id}',
        'edit' => 'battlewheel/{parent_id}/categorie/{id}/modifier',
        'update' => 'battlewheel/{parent_id}/categorie/{id}',
        'destroy' => 'battlewheel/{parent_id}/categorie/{id}',
    ),
    
    'icon' => array(
        'index' => 'categorie/{parent_id}/icone',
        'create' => 'categorie/{parent_id}/icone/creer',
        'store' => 'categorie/{parent_id}/icone',
        'edit' => 'categorie/{parent_id}/icone/{id}/modifier',
        'update' => 'categorie/{parent_id}/icone/{id}',
        'destroy' => 'categorie/{parent_id}/icone/{id}',
        'image' => 'categorie/{parent_id}/icone/{id}/image',
    ),
);