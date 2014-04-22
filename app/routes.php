<?php

Route::filter('anonymous', function() {
    if (Auth::check()) {
        return Redirect::to('/');
    }
});

Route::filter('authentificated', function() {
    if (!Auth::check()) {
        return Redirect::to('/');
    }
});

Route::filter('hasAccessToCategory', function($route) {
    $categoryId = $route->getParameter('category_id');
    $category = Category::find($categoryId);
    $redirect = true;
    
    if (is_object($category) && Auth::check()) {
        $user = $category->user;
        if (is_object($user)) {
            if ($user->id == Auth::getUser()->id) {
                $redirect = false;
            }
        }
    }
    
    if ($redirect) {
        return Redirect::action('CategoryController@index');
    }
});

/*******************************************************************************
 * Routes pour vrai
 ******************************************************************************/
Route::group(
    array(
        'prefix' => LaravelLocalization::setLocale(),
        'before' => 'LaravelLocalizationRoutes'
    ),
    function() {
        if (Auth::check()) {
            Route::get('/', 'BattleWheelController@show');
        } else {
            Route::get('/', 'AuthController@login');
        }

        // Routes pour utilisateurs anonymes
        Route::group(
            array(
                'before' => 'anonymous'
            ),
            function() {
                // user
                Route::post(LaravelLocalization::transRoute('routes.user'), array('before' => 'csrf', 'uses' => 'UserController@store'));
                Route::get( LaravelLocalization::transRoute('routes.user.create'), 'UserController@create');
                Route::get( LaravelLocalization::transRoute('routes.auth.confirmation').'/{key}', 'AuthController@confirmation');
                
                // auth
                Route::get( LaravelLocalization::transRoute('routes.auth.login'), 'AuthController@login');
                Route::post(LaravelLocalization::transRoute('routes.auth.login'), 'AuthController@connect');
            }
        );
        
        // Routes pour utilisateurs connectés
        Route::group(
            array(
                'before' => 'authentificated'
            ),
            function() {
                // auth
                Route::get( LaravelLocalization::transRoute('routes.auth.logout'), 'AuthController@logout');
                
                // battleWheel
                Route::get( LaravelLocalization::transRoute('routes.battleWheel.show'), 'BattleWheelController@show');
                
                // category
                Route::get( LaravelLocalization::transRoute('routes.category.index'), 'CategoryController@index');
                Route::get( LaravelLocalization::transRoute('routes.category.create'), 'CategoryController@create');
                Route::post( LaravelLocalization::transRoute('routes.category.store'), array('before' => 'csrf', 'uses' => 'CategoryController@store'));
                
                // Route qui contiennent un category_id
                Route::group(
                    array(
                        'before' => 'hasAccessToCategory'
                    ),
                    function() {
                        // icons
                        Route::get( LaravelLocalization::transRoute('routes.icon.index'), 'IconController@index');
                        Route::get( LaravelLocalization::transRoute('routes.icon.create'), 'IconController@create');
                        Route::post( LaravelLocalization::transRoute('routes.icon.store'), array('before' => 'csrf', 'uses' => 'IconController@store'));
                    }
                );
            }
        );
        
        // battleWheel, accessible même si on est pas connecté pour simplifié l'accès en game
        Route::get( LaravelLocalization::transRoute('routes.battleWheel.show').'/{user_id}', 'BattleWheelController@showOther');
                
        // Route pour l'image de l'icône, le visionnement est public
        Route::get( LaravelLocalization::transRoute('routes.icon.image'), 'IconController@image');
    }
);