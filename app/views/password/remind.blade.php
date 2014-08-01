@extends('master')

@section('title')
    @lang('reminders.title')
@stop

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">@lang('global.close')</span></button>
            {{ Session::get('error') }}
        </div>
    @elseif (Session::has('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">@lang('global.close')</span></button>
            {{ Session::get('status') }}
        </div>
    @endif
    {{ BootForm::openHorizontal(Config::get('view.bootformLabelWidth'), Config::get('view.bootformInputWidth'))->action(URL::action('RemindersController@postRemind'))->post() }}
        {{ Form::token() }}
        {{ BootForm::email(Lang::get('users.email'), 'email') }}
        {{ BootForm::submit(Lang::get('reminders.send')) }}
    {{ BootForm::close() }}
@stop