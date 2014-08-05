<?php

class CategoryController extends BaseController {
    
    public function index($parentId) {
        $battlewheel = \Battlewheel::find($parentId);
        $categories = $battlewheel->categories;
        if ($categories->isEmpty()) {
            return Redirect::action('CategoryController@create', array($parentId));
        }
        return View::make('category.index')->with('categories', $categories)->with('parentId', $parentId);
    }
    
    public function create($parentId) {
        return View::make('category.create')->with('parentId', $parentId);
    }
    
    public function store($parentId) {
        $validationRules = array(
            'name' => 'required',
        );
        
        $validator = Validator::make(Input::all(), $validationRules);
        if ($validator->fails()) {
            Input::flash();
            return Redirect::action('CategoryController@create', array($parentId))->withErrors($validator);
        }
        else {
            $category = new Category();
            $category->name = Input::get('name');
            $category->battlewheel_id = $parentId;
            $category->save();
            return Redirect::action('CategoryController@index', array($parentId));
        }
    }
    
    public function show($parentId, $id) {
        // Nothing to show for a category
        return App::make('IconController')->index($id);
    }
    
    public function edit($parentId, $id) {
        $category = Category::find($id);
        return View::make('category.edit')->with('category', $category);
    }
    
    public function update($parentId, $id) {
        $validationRules = array(
            'name' => 'required',
        );
        
        $validator = Validator::make(Input::all(), $validationRules);
        if ($validator->fails()) {
            Input::flash();
            return Redirect::action('CategoryController@edit', array($parentId, $id))->withErrors($validator);
        }
        else {
            $category = Category::find($id);
            $category->name = Input::get('name');
            $category->save();
            return Redirect::action('CategoryController@index', array($parentId));
        }
    }
    
    public function destroy($parentId, $id) {
        $category = Category::find($id);
        $category->icons()->delete();
        $category->delete();
        return Redirect::action('CategoryController@index', array($parentId))->with('deleted', '1');;
    }
}