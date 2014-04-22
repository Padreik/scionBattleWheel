@extends('master')

@section('title')
    @lang('icon.title.index')
@stop

@section('header')
    {{ HTML::style('css/icon.css'); }}
@stop

@section('content')
    <div class="row">
        @foreach ($icons as $icon)
            <div class='col-md-1 admin-icon-holder' data-url="{{ URL::action('IconController@edit', array($icon->category_id, $icon->id)) }}">
                <div class='iconHolder'>
                    <img class='iconPreview' src='{{ URL::action('IconController@image', array($icon->category_id, $icon->id)) }}' />
                </div>
                <p class='iconText'>{{ $icon->name }}</p>
            </div>
        @endforeach
    </div>
    <br />
    {{ HTML::linkAction('IconController@create', Lang::get('icon.title.create'), array($category_id)) }}
@stop