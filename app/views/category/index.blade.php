@extends('master')

@section('title')
    @lang('category.title.index')
@stop

@section('content')
    <div class="list-group">
        @foreach ($categories as $category)
            <a href="{{ URL::action('IconController@index', array('id' => $category->id)) }}" class="list-group-item">
                {{ $category->name }}
            </a>
            <a href="/" class="delete-icon-link"><span class="glyphicon glyphicon-remove-sign"></span></a>
            <a href="{{ URL::action('CategoryController@edit', array('id' => $category->id)) }}" class="edit-icon-link"><span class="glyphicon glyphicon-pencil"></span></a>
        @endforeach
    </div>
    <br />
    {{ HTML::linkAction('CategoryController@create', Lang::get('category.title.create')) }}
@stop