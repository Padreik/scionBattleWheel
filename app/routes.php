<?php

Route::group(
    array(
        'prefix' => LaravelLocalization::setLocale(),
        'before' => 'LaravelLocalizationRoutes'
    ),
    function() {
        if (Auth::check()) {
            Route::get('/', 'BattleWheelController@displayDefault');
        } else {
            Route::get('/', 'AuthController@login');
        }

        // Routes pour utilisateurs anonymes
        Route::group(
            array(
                'before' => 'guest'
            ),
            function() {
                // user
                Route::get( LaravelLocalization::transRoute('routes.user.create'), 'UserController@create');
                Route::post(LaravelLocalization::transRoute('routes.user'), array('before' => 'csrf', 'uses' => 'UserController@store'));
                Route::get( LaravelLocalization::transRoute('routes.auth.confirmation').'/{key}', 'AuthController@confirmation');
                
                // auth
                Route::get( LaravelLocalization::transRoute('routes.auth.login'), 'AuthController@login');
                Route::post(LaravelLocalization::transRoute('routes.auth.login'), 'AuthController@connect');
                
                // Reminder
                Route::controller('password', 'RemindersController');
            }
        );
        
        // Routes pour utilisateurs connectés
        Route::group(
            array(
                'before' => 'auth'
            ),
            function() {
                Route::group(
                    array(
                        'prefix' => 'admin',
                    ),
                    function() {
                        // battleWheel
                        Route::group(
                            array(
                                'before' => 'hasAccessInAdmin:BattleWheel',
                            ),
                            function() {
                                \pgirardnet\Scion\RoutesHelpers::translatedResource('battleWheel');
                            }
                        );
                        // category
                        Route::group(
                            array(
                                'before' => 'hasAccessInAdmin:Category',
                            ),
                            function() {
                                \pgirardnet\Scion\RoutesHelpers::translatedResource('category');
                            }
                        );
                        // icons
                        Route::group(
                            array(
                                'before' => 'hasAccessInAdmin:Icon',
                            ),
                            function() {
                                \pgirardnet\Scion\RoutesHelpers::translatedResource('icon', array(
                                    'except' => array('show')
                                ));
                            }
                        );
                    }
                );
            
                // auth
                Route::get( LaravelLocalization::transRoute('routes.auth.logout'), 'AuthController@logout');
                
                // battleWheel
                Route::get( 'bw', 'BattleWheelController@showtmp');
            }
        );
        
        // battleWheel, accessible même si on est pas connecté pour simplifié l'accès en game
        Route::get( LaravelLocalization::transRoute('routes.battleWheel.show').'/{user_id}', 'BattleWheelController@showOther');
                
        // Route pour l'image de l'icône, le visionnement est public
        Route::get( LaravelLocalization::transRoute('routes.icon.image'), 'IconController@image');
    }
);