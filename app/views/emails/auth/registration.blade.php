<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>@lang('auth.confirmation.title')</h2>

        <div>
            @lang('auth.confirmation.message')
            : {{ HTML::linkAction('AuthController@confirmation', Lang::get('auth.confirmation.link'), array('key' => $confirmation)) }}.
        </div>
    </body>
</html>