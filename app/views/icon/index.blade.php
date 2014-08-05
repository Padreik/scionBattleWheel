@extends('master')

@section('title')
    @lang('icon.title.index')
@stop

@section('header')
    {{ HTML::style('css/icon.css'); }}
@stop

@section('content')
    @if(Session::has('deleted'))
        <div class="alert alert-success">
            @lang('icon.deleted')
        </div>
    @endif
    <?php $csrfToken = csrf_token(); ?>
    <div class="row">
        @foreach ($icons as $icon)
            <div class='admin-icon-holder' data-url="{{ URL::action('IconController@edit', array($icon->category_id, $icon->id)) }}">
                <div class='iconHolder'>
                    <img class='iconPreview' src='{{ URL::action('IconController@image', array($icon->category_id, $icon->id)) }}' />
                </div>
                <p class='iconText'>{{ $icon->name }}</p>
                <a href="{{ URL::action('IconController@destroy', array($icon->category_id, $icon->id)) }}" class="delete-icon-link" data-method="delete" data-token="{{ $csrfToken }}" data-confirm="{{ Lang::get('icon.delete.confirmation') }}">
                    <span class="glyphicon glyphicon-remove-sign img-circle"></span>
                </a>
            </div>
        @endforeach
    </div>
    <br />
    {{ HTML::linkAction('IconController@create', Lang::get('icon.title.create'), array($category_id)) }}
    {{ HTML::script('js/laravelRestfulLink.js'); }}
@stop