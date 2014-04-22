<?php

class CategoryController extends BaseController {
    
    public function index() {
        $categories = Auth::getUser()->categories;
        if ($categories->isEmpty()) {
            return Redirect::action('CategoryController@create');
        }
        return View::make('category.index')->with('categories', $categories);
    }
    
    public function create() {
        return View::make('category.create');
    }
    
    public function store() {
        $validationRules = array(
            'name' => 'required',
        );
        
        $validator = Validator::make(Input::all(), $validationRules);
        if ($validator->fails()) {
            Input::flash();
            return Redirect::action('CategoryController@create')->withErrors($validator);
        }
        else {
            $category = new Category();
            $category->name = Input::get('name');
            $category->user_id = Auth::getUser()->id;
            $category->save();
            return Redirect::action('CategoryController@index');
        }
    }
}