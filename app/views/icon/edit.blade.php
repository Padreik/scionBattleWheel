@extends('master')

@section('title')
    @lang('icon.title.create')
@stop

@section('header')
    {{ HTML::script('js/jquery.imgareaselect.pack.js'); }}
    {{ HTML::style('css/imgareaselect-animated.css'); }}
    {{ HTML::style('css/icon.css'); }}
@stop

@section('content')
    {{ BootForm::openHorizontal(Config::get('view.bootformLabelWidth'), Config::get('view.bootformInputWidth'))->action(URL::action('IconController@update', array($icon->category_id, $icon->id)))->multipart()->put() }}
        {{ BootForm::bind($icon) }}
        {{ Form::token() }}
        {{ BootForm::text(Lang::get('icon.name'), 'name') }}
        <div class="form-group">
            <label class="col-lg-2 control-label">Image courante</label>
            <div class="col-lg-10">
                <img class='iconPreview' src='{{ URL::action('IconController@image', array($icon->category_id, $icon->id)) }}' />
            </div>
        </div>
        {{ BootForm::file(Lang::get('icon.image'), 'image') }}
        @if(!BootForm::hasError('image') && BootForm::hasError('x1'))
            <div class="has-error col-md-offset-2">
                <p class='help-block'>
                    @lang('icon.error.create.select')
                </p>
            </div>
        @endif
        <div class='row previewsRow'>
            <div class='col-md-2 iconAndTextHolder'>
                <div class='iconHolder'>
                    <img id='iconPreview' />
                </div>
                <p class='iconText'>{{ $icon->name }}</p>
            </div>
            <div class='col-md-10'>
                <img id='imagePreview' class='img-responsive' />
            </div>
            {{ BootForm::hidden('x1') }}
            {{ BootForm::hidden('y1') }}
            {{ BootForm::hidden('x2') }}
            {{ BootForm::hidden('y2') }}
            {{ BootForm::hidden('ratio') }}
        </div>
        {{ BootForm::submit(Lang::get('icon.store')) }}
    {{ BootForm::close() }}
    
    {{ HTML::script('js/icon.create.js'); }}
@stop