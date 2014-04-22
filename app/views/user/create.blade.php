@extends('master')

@section('title')
    @lang('users.title.create')
@stop

@section('content')
    {{ BootForm::openHorizontal(Config::get('view.bootformLabelWidth'), Config::get('view.bootformInputWidth'))->action(URL::action('UserController@store')) }}
        {{ Form::token() }}
        {{ BootForm::email(Lang::get('users.email'), 'email') }}
        {{ BootForm::password(Lang::get('users.password'), 'password') }}
        {{ BootForm::password(Lang::get('users.password_confirmation'), 'password_confirmation') }}
        {{ BootForm::submit(Lang::get('users.store')) }}
    {{ BootForm::close() }}
@stop