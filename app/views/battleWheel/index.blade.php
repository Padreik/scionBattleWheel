@extends('master')

@section('title')
    @lang('battlewheel.title.index')
@stop

@section('content')
    <div class="list-group">
        @foreach ($battlewheels as $battlewheel)
            <a href="{{ URL::action('BattleWheelController@show', array('id' => $battlewheel->id)) }}" class="list-group-item">
                {{ $battlewheel->name }}
            </a>
        @endforeach
    </div>
@stop