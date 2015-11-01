@extends('layouts.column2')
@section('content')
    <div class="page-product">
        <div class="row product-info cart-item">
            <div class="col-sm-5 images-block">
            	<p class="image">{!! $product->present()->featured_image('img-responsive thumbnail') !!}</p>
            	{!! $product->present()->slider_images !!}
            </div>
            <div class="col-sm-7 product-details">
            	<h2 class="name">{{$product->name}}</h2>
            	<hr>
            	{!! $product->present()->info !!}
            	<hr>
            	<div class="price">
            		<span class="price-head">{{trans('product::common.price')}} :</span>
            		{!!$product->present()->price('đ', 'price-new')!!}
            		{!!$product->present()->price_old('đ', 'price-old')!!}
            	</div>
            	<hr>
            	<div class="options">
            		{!! Form::open(['class' => 'form-cart form-horizontal']) !!}
            		<div class="form-group">
            			{!! Form::label('quantity', trans('shop::cart.quantity'), ['class' => 'col-xs-3 control-label text-uppercase']) !!}
            			<div class="col-xs-9">
            				{!! Form::text('quantity', 1, ['class' => 'form-control']) !!}
            			</div>
            		</div>
            		<div class="cart-button">
                        <a href="{{route('wishlist.update', ['product' => $product->id])}}" data-action="wishlist-update" data-toggle="tooltip" title="{{trans('shop::cart.wishlist')}}" class="btn btn-wishlist{{$wishlist_added}}">
            				<i class="fa fa-heart"></i>
            			</a>
            			<a href="{{route('wishlist.compare', ['product' => $product->id])}}" data-toggle="tooltip" title="{{trans('shop::cart.compare')}}" class="btn btn-compare">
            				<i class="fa fa-bar-chart-o"></i>
            			</a>
            			<a href="{{route('cart.add', ['product' => $product->id])}}" class="btn btn-cart">
            				{{trans('shop::cart.add')}} <i class="fa fa-shopping-cart"></i>
            			</a>
            		</div>
            		{!! Form::close() !!}
            	</div>
            	<hr>
            </div>
        </div>
        <div class="product-info-box">
            <h4 class="heading">{{trans('product::common.description')}}</h4>
            <div class="content panel-smart">
            	{!! $product->description !!}
            </div>
        </div>
        @if($related_products->count())
        <div class="product-info-box">
            <h4 class="heading">{{trans('product::common.related')}}</h4>
            {!! ShopWidget::productsList($related_products) !!}
        </div>
        @endif
    </div>
@endsection

@section('script')
@parent
<script type="text/javascript">
    $(document).ready(function () {
        $('.slider-images').show().bxSlider({
            minSlides: 3,
            maxSlides: 12,
            slideWidth: {{config('image.thumbnail.width')}},
            slideMargin: 6,
            adaptiveHeight: true,
            auto: true,
            pager: true,
			onSliderLoad: function(){
				$(".bx-clone").children().removeAttr("data-lightbox");
			}
        });
    });
</script>
@endsection