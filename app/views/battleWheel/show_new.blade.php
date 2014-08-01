@extends('masterBlank')

@section('title')
    @lang('layout.title')
@stop

@section('header')
    {{ HTML::style('css/battlewheel.css'); }}
@stop

@section('content')
    <div class="clearfix">
        <div id="wheel" class="col-md-8">
            {{ HTML::image('Scion_Battle_Wheel/tiggerherz_wheel.jpg') }}

            <div class="selector">
                Wheel: 
                <select class="form-control" onchange="document.getElementById('wheelImg').src = 'Scion_Battle_Wheel/' + this.value + '.jpg';">
                    <option value="exalted_wheel">Exalted</option>
                    <option value="exalted_wheel_large">Exalted (Large)</option>
                    <option value="kuhan_wheel">Kuhan</option>
                    <option value="kuhan_wheel_large">Kuhan (large)</option>
                    <option value="tiggerherz_wheel" selected="selected">Tiggerherz</option>
                    <option value="tiggerherz_wheel_big">Tiggerherz (large)</option>
                    <option value="voidstate_wheel">Voidstate</option>
                </select>
            </div>
        </div>

        <div id="gallery" class="col-md-4">
            <div id="categories" class="well">
                <a href="#" id="firstCategory">&lt;&lt;</a> | 
                <a href="#" id="previousCategory">&lt;</a> | 
                <select id="caregorySelector" class="form-control">
                    <?php $indice = 0; ?>
                    @foreach ($user->categories as $category)
                        <option value="{{ $indice++ }}">{{ $category->name }}</option>
                    @endforeach
                </select> |
                <a href="#" id="nextCategory">&gt;</a> | 
                <a href="#" id="lastCategory">&gt;&gt;</a>
            </div>

            <div id="icons" class="well clearfix">
                <?php $indice = 0; ?>
                @foreach ($user->categories as $category)
                    <div id="{{ $indice++ }}" class="category-icons pull-left clearfix">
                        <h2>{{ $category->name }}</h2>
                        @foreach ($category->icons as $icon)
                            <div class="icon" id="{{ $icon->id }}">
                                {{ HTML::image('images/battlewheel/redX.bmp', Lang::get('global.close'), array('class' => 'close')) }}
                                <img src="{{ URL::action('IconController@image', array($icon->category_id, $icon->id)) }}" class="image" />
                                <input value="{{ $icon->name }}" class="iconInput" id="iconInput{{ $icon->id }}" type="text" />
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="floatingIcons"></div>
    {{ HTML::script('js/battlewheel.js'); }}
@stop