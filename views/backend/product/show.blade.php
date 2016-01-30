@extends('backend.layouts.main')
@section('content')
<table class="table table-hover table-striped table-bordered table-detail">
    <tr>
        <td>ID</td>
        <td><strong>{{ $product->id}}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::common.code') }}</td>
        <td><strong>{{ $product->code}}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::common.name') }}</td>
        <td><strong>{{ $product->name}}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::common.slug') }}</td>
        <td><strong>{{ $product->slug}}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::common.price') }}</td>
        <td><strong>{{ $product->present()->price}}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::common.price_old') }}</td>
        <td><strong>{{ $product->present()->price_old}}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::common.size') }}</td>
        <td><strong>{{ $product->size}}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::common.featured_image') }}</td>
        <td>{!! $product->present()->featured_image !!}</td>
    </tr>
    <tr>
        <td>{{ trans('product::common.images') }}</td>
        <td>{!! $product->present()->lightbox_images !!}</td>
    </tr>
    <tr>
        <td>{{ trans('product::common.description') }}</td>
        <td>{!! $product->description!!}</td>
    </tr>
    <tr>
        <td>{{ trans('product::common.manufacturer_id') }}</td>
        <td><strong>{{ $product->present()->manufacturer }}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::common.category_id') }}</td>
        <td><strong>{{ $product->present()->category }}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::common.is_special') }}</td>
        <td><strong>{!! $product->present()->is_special !!}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::common.gender_id') }}</td>
        <td><strong>{{ $product->present()->gender }}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::common.age_id') }}</td>
        <td><strong>{{ $product->present()->age }}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('product::common.tags') }}</td>
        <td>{!! $product->present()->tagsHtml !!}</td>
    </tr>
    <tr>
        <td>{{ trans('product::common.user_id') }}</td>
        <td><strong>{{ $product->user->username }}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('common.created_at') }}</td>
        <td>{!! $product->present()->createdAt !!}</td>
    </tr>
    <tr>
        <td>{{ trans('common.updated_at') }}</td>
        <td>{!! $product->present()->updatedAt !!}</td>
    </tr>
</table>
@stop