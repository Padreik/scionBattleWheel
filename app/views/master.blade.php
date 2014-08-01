@extends('masterBlank')

@section('header')
    @yield('header')
@stop

@section('content')
    <div class='container'>
        <h1>@yield('title')</h1>
        @yield('content')
    </div>
@overwrite