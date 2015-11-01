@extends('backend.layouts.modal')
@section('content')
{!! Form::model($manufacturer, ['files' => true, 'class' => 'form-horizontal','url' => $url, 'method' => $method]) !!}
<div class="form-group{{ $errors->has('name') ? ' has-error':'' }}">
    {!! Form::label('name', trans('product::manufacturer.name'), ['class' => "col-xs-3 control-label"]) !!}
    <div class="col-xs-9">
        {!! Form::text('name', null, ['class' => 'has-slug form-control','data-slug_target' => "#name-slug"]) !!}
        @if($errors->has('name'))
            <p class="help-block">{{ $errors->first('name') }}</p>
        @endif
    </div>
</div>
<div class="form-group{{ $errors->has('slug') ? ' has-error':'' }}">
    {!! Form::label('slug', trans('product::manufacturer.slug'), ['class' => "col-xs-3 control-label"]) !!}
    <div class="col-xs-9">
        {!! Form::text('slug', null, ['id'=>'name-slug', 'class' => 'form-control']) !!}
        @if($errors->has('slug'))
            <p class="help-block">{{ $errors->first('slug') }}</p>
        @endif
    </div>
</div>
<div class="form-group{{ $errors->has('logo') ? ' has-error':'' }}">
    {!! Form::label('logo', trans('product::manufacturer.logo'), ['class' => 'col-xs-3 control-label']) !!}
    <div class="col-xs-9">
        {!! Form::selectImage('logo', ['class' => 'form-control', 'thumbnail'=>[
            'url' => $manufacturer->getLogoUrl(),
            'width' => $logo_size,
            'height' => $logo_size
        ]]) !!}
        @if($errors->has('logo'))
            <p class="help-block">{{ $errors->first('logo') }}</p>
        @endif
    </div>
</div>
{!! Form::close() !!}
@stop