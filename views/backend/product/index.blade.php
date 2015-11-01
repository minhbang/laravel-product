@extends('backend.layouts.main')
@section('content')
<div id="product-manage-tools" class="hidden">
    <div class="dataTables_toolbar">
        {!! Html::linkButton('#', trans('common.search'), ['class'=>'advanced_search_collapse','type'=>'info', 'size'=>'xs', 'icon' => 'search']) !!}
        {!! Html::linkButton('#', trans('common.all'), ['class'=>'filter-clear', 'type'=>'warning', 'size'=>'xs', 'icon' => 'list']) !!}
        {!! Html::linkButton(route('backend.product.create'), trans('product::common.create'), ['type'=>'success', 'size'=>'xs', 'icon' => 'plus-sign']) !!}
    </div>
    <div class="bg-warning dataTables_advanced_search">
        <form class="form-horizontal" role="form">
            {!! Form::hidden('search_form', 1) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('search_category_id', trans('product::common.category_id'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::select('search_category_id', $categories, null, ['prompt' => '', 'class' => 'form-control selectize-tree']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('search_gender_id', trans('product::common.gender_id'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::select('search_gender_id', $genders, null, ['prompt' => '', 'class' => 'form-control selectize']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('search_age_id', trans('product::common.age_id'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::select('search_age_id', $ages, null, ['prompt' => '', 'class' => 'form-control selectize']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('search_created_at', trans('common.created_at'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::daterange('search_created_at', [], ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('search_updated_at', trans('common.updated_at'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::daterange('search_updated_at', [], ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="ibox ibox-table">
    <div class="ibox-title">
        <h5>{!! trans('product::common.manage_title') !!}</h5>
    </div>
    <div class="ibox-content">
    {!! $table->render('_datatable') !!}
    </div>
</div>
@stop
@section('script')
    @include(
        '_datatable_script',
        [
            'name' => trans('product::common.product'),
            'data_url' => route('backend.product.data'),
        ]
    )
@stop