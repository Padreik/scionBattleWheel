@extends('master')

@section('title')
    @lang('category.title.create')
@stop

@section('content')
    {{ BootForm::openHorizontal(Config::get('view.bootformLabelWidth'), Config::get('view.bootformInputWidth'))->action(URL::action('CategoryController@update', array($category_id)))->put() }}
        {{ BootForm::bind($category) }}
        {{ Form::token() }}
        {{ BootForm::text(Lang::get('category.name'), 'name') }}
        {{ BootForm::submit(Lang::get('category.update')) }}
    {{ BootForm::close() }}
@stop