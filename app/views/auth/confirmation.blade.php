@extends('master')

@section('title')
    @lang('auth.title.confirmation')
@stop

@section('content')
    @if ($success)
        @lang('auth.confirmation.success').
    @else
        @lang('auth.confirmation.error').
    @endif
@stop