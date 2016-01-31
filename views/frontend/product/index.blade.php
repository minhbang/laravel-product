@extends('layouts.column2')
@section('content')
    <div class="page-products">
        <div class="main-heading">{{trans('product::common.product')}}</div>
        @include('shop::frontend._display_options', ['options' => $product_options])
        {!! ShopWidget::productsList($products) !!}
        {!! Html::pagination($products, trans('product::common.product')) !!}
    </div>
@endsection