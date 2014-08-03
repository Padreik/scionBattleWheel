<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
            @yield('title') - 
            @lang('layout.title')
        </title>
        
        <!-- JQuery CDN -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>

        <!-- Bootstrap CDN -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        
        {{ HTML::style('css/sticky-footer.css'); }}
        {{ HTML::style('css/layout.css'); }}
        
        @yield('header')
    </head>
    <body>
        <div class="navbar navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ URL::to('/') }}">@lang('layout.title')</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        @if (Auth::check())
                            <li>
                                {{ HTML::linkAction('BattleWheelController@index', Lang::get('layout.admin')) }}
                            </li>
                            <li>
                                {{ HTML::linkAction('AuthController@logout', Lang::get('layout.logout')) }}
                            </li>
                        @else
                            <li>
                                {{ HTML::linkAction('AuthController@login', Lang::get('layout.login')) }}
                            </li>
                            <li>
                                {{ HTML::linkAction('UserController@create', Lang::get('layout.create_account')) }}
                            </li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav pull-right">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            @unless (LaravelLocalization::getCurrentLocale() == $localeCode)
                                <li>
                                    <a hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">{{{ $properties['native'] }}}</a>
                                </li>
                            @endunless
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @yield('content')
        <div id='footer'>
            <div class='container'>
                <p class='text-muted'>@lang('layout.footer')</p>
            </div>
        </div>
        {{ HTML::script('js/layout.js') }}
    </body>
</html>