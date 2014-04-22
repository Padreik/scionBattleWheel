@extends('master')

@section('title')
    @lang('category.title.index')
@stop

@section('content')
    @if(Session::has('deleted'))
        <div class="alert alert-success">
            @lang('category.deleted')
        </div>
    @endif
    <?php $csrfToken = csrf_token(); ?>
    <div class="list-group">
        @foreach ($categories as $category)
            <a href="{{ URL::action('IconController@index', array('id' => $category->id)) }}" class="list-group-item">
                {{ $category->name }}
            </a>
            <a href="{{ URL::action('CategoryController@delete', array('id' => $category->id)) }}" class="delete-icon-link" data-method="delete" data-token="{{ $csrfToken }}" data-confirm="{{ Lang::get('category.delete.confirmation') }}">
                <span class="glyphicon glyphicon-remove-sign"></span>
            </a>
            <a href="{{ URL::action('CategoryController@edit', array('id' => $category->id)) }}" class="edit-icon-link"><span class="glyphicon glyphicon-pencil"></span></a>
        @endforeach
    </div>
    <br />
    {{ HTML::linkAction('CategoryController@create', Lang::get('category.title.create')) }}
    {{ HTML::script('js/laravelRestfulLink.js'); }}
@stop