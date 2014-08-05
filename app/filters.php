<?php

Route::filter('hasAccessInAdmin', function($route, $request, $value) {
    $id = $route->getParameter('id');
    $parentId = $route->getParameter('parent_id');
    if (!is_null($id)) {
        $object = call_user_func(array("\\".$value, "find"), $id);
        if (is_a($object, 'AccessibleInAdmin') && !$object->hasAccessInAdmin()) {
            if (!is_null($parentId)) {
                return Redirect::action($value."Controller@index", array('parent_id' => $parentId));
            }
            else {
                return Redirect::action($value."Controller@index");
            }
        }
    }
    elseif (!is_null($parentId)) {
        $parentClass = call_user_func(array("\\".$value, "getParentClass"));
        $parent = call_user_func(array("\\".$parentClass, "find"), $parentId);
        if (is_a($parent, 'AccessibleInAdmin') && !$parent->hasAccessInAdmin()) {
            return Redirect::back();
        }
    }
});

Route::filter('hasValidParent', function($route, $request, $value) {
    $id = $route->getParameter('id');
    $parentId = $route->getParameter('parent_id');
    if (!is_null($id) && !is_null($parentId)) {
        $object = call_user_func(array("\\".$value, "find"), $id);
        if (is_a($object, 'HaveParent') && !$object->isParentIdValid()) {
            return Redirect::action($value."Controller@index", array('parent_id' => $parentId));
        }
    }
});

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('/');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});