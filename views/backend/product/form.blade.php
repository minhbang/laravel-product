@extends('backend.layouts.main')
@section('content')
    {!! Form::model($product, ['id' => 'product-form', 'files' => true, 'url' => $url, 'method' => $method]) !!}
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{!! trans('product::common.information') !!}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="form-group{{ $errors->has("name") ? ' has-error':'' }}">
                        {!! Form::label("name", trans('product::common.name'), ['class' => "control-label"]) !!}
                        {!! Form::text("name", null, ['class' => 'has-slug form-control','data-slug_target' => "#name-slug"]) !!}
                        @if($errors->has("name"))
                            <p class="help-block">{{ $errors->first("name") }}</p>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has("slug") ? ' has-error':'' }}">
                        {!! Form::label("slug", trans('product::common.slug'), ['class' => "control-label"]) !!}
                        {!! Form::text("slug", null, ['id'=>"name-slug", 'class' => 'form-control']) !!}
                        @if($errors->has("slug"))
                            <p class="help-block">{{ $errors->first("slug") }}</p>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has("description") ? ' has-error':'' }}">
                        {!! Form::label("description", trans('product::common.description'), ['class' => "control-label"]) !!}
                        {!! Form::textarea("description", null, [
                            'class' => 'form-control wysiwyg',
                            'data-editor' => 'basic_no_image',
                            'data-height' => 350,
                            'data-attribute' => 'description',
                            'data-resource' => 'product',
                            'data-id' => $product->id
                        ]) !!}
                        @if($errors->has("description"))
                            <p class="help-block">{{ $errors->first("description") }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{!! trans('product::common.images') !!}</h5>
                    <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                </div>
                <div class="ibox-content has-ibox">
                    <div id="product-images"></div>
                    {!! Form::hidden('linked_image_ids', null, ['id' => 'linked_image_ids']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{trans('product::common.properties')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has("code") ? ' has-error':'' }}">
                                {!! Form::label("code", trans('product::common.code'), ['class' => "control-label"]) !!}
                                {!! Form::text("code", null, ['class' => 'form-control']) !!}
                                @if($errors->has("code"))
                                    <p class="help-block">{{ $errors->first("code") }}</p>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has("price") ? ' has-error':'' }}">
                                {!! Form::label("price", trans('product::common.price'), ['class' => "control-label"]) !!}
                                <div class="input-group">
                                    {!! Form::text("price", null, ['class' => 'form-control text-right number']) !!}
                                    <span class="input-group-addon">đồng</span>
                                </div>
                                @if($errors->has("price"))
                                    <p class="help-block">{{ $errors->first("price") }}</p>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has("price_old") ? ' has-error':'' }}">
                                {!! Form::label("price_old", trans('product::common.price_old'), ['class' => "control-label"]) !!}
                                <div class="input-group">
                                    {!! Form::text("price_old", null, ['class' => 'form-control text-right number']) !!}
                                    <span class="input-group-addon">đồng</span>
                                </div>
                                @if($errors->has("price_old"))
                                    <p class="help-block">{{ $errors->first("price_old") }}</p>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has("size") ? ' has-error':'' }}">
                                {!! Form::label("size", trans('product::common.size'), ['class' => "control-label"]) !!}
                                {!! Form::text("size", null, ['class' => 'form-control']) !!}
                                @if($errors->has("size"))
                                    <p class="help-block">{{ $errors->first("size") }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-image{{ $errors->has('image') ? ' has-error':'' }}">
                                {!! Form::label('image', trans('product::common.featured_image'), ['class' => 'control-label']) !!}
                                {!! Form::selectImage('image', ['thumbnail' => [
                                    'url' => $product->featured_image_url,
                                    'width' => $product->config['featured_image']['width'],
                                    'height' => $product->config['featured_image']['height']
                                ]]) !!}
                                @if($errors->has('image'))
                                    <p class="help-block">{{ $errors->first('image') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{ trans('product::common.group') }}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('is_special') ? ' has-error':'' }}">
                                {!! Form::label('is_special', trans('product::common.is_special'), ['class' => 'control-label switch-label']) !!}
                                {!! Form::checkbox('is_special', 1, null,['class' => 'switch', 'data-on-text'=>trans('common.yes'), 'data-off-text'=>trans('common.no')]) !!}
                                @if($errors->has('is_special'))
                                    <p class="help-block">{{ $errors->first('is_special') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has("manufacturer_id") ? ' has-error':'' }}">
                                {!! Form::label("manufacturer_id", trans('product::common.manufacturer_id'), ['class' => "control-label"]) !!}
                                {!! Form::select("manufacturer_id", $manufacturers, null, ['prompt' => '', 'class' => 'form-control selectize']) !!}
                                @if($errors->has("manufacturer_id"))
                                    <p class="help-block">{{ $errors->first("manufacturer_id") }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has("gender_id") ? ' has-error':'' }}">
                                {!! Form::label("gender_id", trans('product::common.gender_id'), ['class' => "control-label"]) !!}
                                {!! Form::select("gender_id", $genders, null, ['class' => 'form-control selectize']) !!}
                                @if($errors->has("gender_id"))
                                    <p class="help-block">{{ $errors->first("gender_id") }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has("age_id") ? ' has-error':'' }}">
                                {!! Form::label("age_id", trans('product::common.age_id'), ['class' => "control-label"]) !!}
                                {!! Form::select("age_id", $ages, null, ['class' => 'form-control selectize']) !!}
                                @if($errors->has("age_id"))
                                    <p class="help-block">{{ $errors->first("age_id") }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has("category_id") ? ' has-error':'' }}">
                        {!! Form::label("category_id", trans('product::common.category_id'), ['class' => "control-label"]) !!}
                        {!! Form::select("category_id", $categories, null, ['prompt' => '', 'class' => 'form-control selectize-tree']) !!}
                        @if($errors->has("category_id"))
                            <p class="help-block">{{ $errors->first("category_id") }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('tags', trans('product::common.tags'), ['class' => 'control-label']) !!}
                        {!! Form::text('tags', $tags, ['data-options'=>$all_product_tags, 'prompt' =>'', 'class' => 'form-control selectize-tags']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="form-group text-center">
                <button type="submit" class="btn btn-success" style="margin-right: 15px;">{{ trans('common.save') }}</button>
                <a href="{{ route('backend.product.index') }}" class="btn btn-white">{{ trans('common.cancel') }}</a>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.wysiwyg').mbEditor();
            $('#product-images').mbDropzone({
                all_tags: '{!!$all_image_tags!!}',
                preview_grid: "col-lg-6 col-md-4 col-sm-6 col-xs-6",
                images: {!! $images !!}
            });

            $('#product-form').submit(function(){
                var linked_image_ids = [],
                    product_images = $('#product-images');
                $('.dz-image-uploaded', product_images).each(function(){
                    var id = $(this).data('id');
                    if(id){
                        linked_image_ids.push(id);
                    }
                });
                $('#linked_image_ids').val(linked_image_ids.join(','));
            });
        });
    </script>
@stop