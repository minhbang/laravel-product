@extends('backend.layouts.modal')
@section('content')
<table class="table table-hover table-striped table-bordered table-detail">
    <tr>
        <td>ID</td>
        <td><strong>{{ $manufacturer->id}}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::manufacturer.name') }}</td>
        <td><strong>{{ $manufacturer->name }}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::manufacturer.slug') }}</td>
        <td><strong>{{ $manufacturer->slug }}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::manufacturer.position') }}</td>
        <td><strong>{{ $manufacturer->position }}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::manufacturer.logo') }}</td>
        <td>{!! $manufacturer->present()->logo !!}</td>
    </tr>
</table>
@stop