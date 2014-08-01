@extends('master')

@section('title')
    @lang('reminders.reset.title')
@stop

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">@lang('global.close')</span></button>
            {{ Session::get('error') }}
        </div>
    @endif
    {{ BootForm::openHorizontal(Config::get('view.bootformLabelWidth'), Config::get('view.bootformInputWidth'))->action(URL::action('RemindersController@postReset'))->post() }}
        {{ Form::token() }}
        {{ BootForm::hidden('token')->value($token) }}
        {{ BootForm::email(Lang::get('users.email'), 'email') }}
        {{ BootForm::password(Lang::get('users.password'), 'password') }}
        {{ BootForm::password(Lang::get('users.password_confirmation'), 'password_confirmation') }}
        {{ BootForm::submit(Lang::get('reminders.send')) }}
    {{ BootForm::close() }}
@stop