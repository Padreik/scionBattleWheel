<?php

namespace pgirardnet\Scion;

class RoutesHelpers {
    protected static $defaultVerbs = array('index', 'create', 'store', 'show', 'edit', 'update', 'destroy');
    
    static public function translatedResource($key, $parameters = array()) {
        if (isset($parameters['only'])) {
            $verbs = $parameters['only'];
        }
        elseif (isset($parameters['except'])) {
            $verbs = array_diff(static::$defaultVerbs, $parameters['except']);
        }
        else {
            $verbs = static::$defaultVerbs;
        }
        foreach ($verbs as $verb) {
            call_user_func(__NAMESPACE__."\RoutesHelpers::createRoute".ucfirst($verb), $key);
        }
    }
    
    static protected function createRouteIndex($key) {
        \Route::get( \LaravelLocalization::transRoute("routes.$key.index"), ucfirst($key).'Controller@index');
    }
    
    static protected function createRouteCreate($key) {
        \Route::get( \LaravelLocalization::transRoute("routes.$key.create"), ucfirst($key).'Controller@create');
    }
    
    static protected function createRouteStore($key) {
        \Route::post( \LaravelLocalization::transRoute("routes.$key.store"), array('before' => 'csrf', 'uses' => ucfirst($key).'Controller@store'));
    }
    
    static protected function createRouteShow($key) {
        \Route::get( \LaravelLocalization::transRoute("routes.$key.show"), ucfirst($key).'Controller@show');
    }
    
    static protected function createRouteEdit($key) {
        \Route::get( \LaravelLocalization::transRoute("routes.$key.edit"), ucfirst($key).'Controller@edit');
    }
    
    static protected function createRouteUpdate($key) {
        \Route::put( \LaravelLocalization::transRoute("routes.$key.update"), array('before' => 'csrf', 'uses' => ucfirst($key).'Controller@update'));
    }
    
    static protected function createRouteDestroy($key) {
        \Route::delete( \LaravelLocalization::transRoute("routes.$key.destroy"), array('before' => 'csrf', 'uses' => ucfirst($key).'Controller@destroy'));
    }
}
