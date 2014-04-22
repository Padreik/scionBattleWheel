@extends('master')

@section('title')
    @lang('category.title.index')
@stop

@section('content')
    <div class="list-group">
        @foreach ($categories as $category)
            {{ HTML::linkAction('IconController@index', $category->name, array('id' => $category->id), array('class' => 'list-group-item')) }}
        @endforeach
    </div>
    <br />
    {{ HTML::linkAction('CategoryController@create', Lang::get('category.title.create')) }}
@stop