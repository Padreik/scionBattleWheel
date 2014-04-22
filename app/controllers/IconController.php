<?php

class IconController extends BaseController {
    
    public function index($category_id) {
        $category = Category::find($category_id);
        
        $icons = $category->icons;
        
        if ($icons->isEmpty()) {
            return Redirect::action('IconController@create', array($category_id));
        }
        return View::make('icon.index')->with('icons', $icons)->with('category_id', $category_id);
    }
    
    public function create($category_id) {
        return View::make('icon.create')->with('category_id', $category_id);
    }
    
    public function store($category_id) {
        $validationRules = array(
            'name' => 'required',
            'image' => 'required|image',
            'x1' => 'required|numeric'
        );
        
        $validator = Validator::make(Input::all(), $validationRules);
        if ($validator->fails()) {
            Input::flashOnly('name');
            return Redirect::action('IconController@create', array($category_id))->withErrors($validator);
        }
        else {
            $icon = new Icon();
            $icon->name = Input::get('name');
            $icon->image = $this->createIcon();
            $icon->category_id = $category_id;
            $icon->save();
            return Redirect::action('IconController@index');
        }
    }
    
    protected function createIcon() {
        $iconWidth = Input::get('x2') - Input::get('x1');
        $iconHeight = Input::get('y2') - Input::get('y1');
        return Image::make(Input::file('image')->getRealPath())->crop($iconWidth, $iconHeight, Input::get('x1'), Input::get('y1'))->resize(50, 50)->encode('data-url');
    }
    
    public function image($category_id, $icon_id) {
        $icon = Icon::find($icon_id);
        if (is_object($icon) && $icon->category_id == $category_id) {
            preg_match("/^data:(.*);base64,(.*)$/", $icon->image, $matches);
            // echo "<img src='data:$matches[1];base64,$matches[2]' />";
            // dd($matches);
            // In the blob, it starts with: data:image/png;... for a png image
            $response = Response::make(base64_decode($matches[2]), 200);
            $response->header('Content-Type', $matches[1]);
            return $response;
        }
    }
}