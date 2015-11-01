@extends('layouts.column2')
@section('content')
    <div class="page-products">
        {!! ShopWidget::productsList($products) !!}
        {!! Html::pagination($products, trans('product.product')) !!}
    </div>
@endsection