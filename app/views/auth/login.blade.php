@extends('master')

@section('title')
    @lang('auth.title.login')
@stop

@section('content')
    @if(Session::has('login_error'))
        <div class="alert alert-danger">
            @lang('auth.login_error')
        </div>
    @endif

    {{ BootForm::openHorizontal(Config::get('view.bootformLabelWidth'), Config::get('view.bootformInputWidth'))->action(URL::action('AuthController@connect')) }}
        {{ Form::token() }}
        {{ BootForm::email(Lang::get('users.email'), 'email') }}
        {{ BootForm::password(Lang::get('users.password'), 'password') }}
        {{ BootForm::submit(Lang::get('auth.connect')) }}
    {{ BootForm::close() }}
@stop