@extends('backend.layouts.main')
@section('content')
    <div id="manufacturer-manage-tools" class="hidden">
        <div class="dataTables_toolbar">
            {!! Html::linkButton('#', trans('common.all'), ['class'=>'filter-clear', 'type'=>'warning', 'size'=>'xs', 'icon' => 'list']) !!}
            {!! Html::modalButton(
                route('backend.manufacturer.create'),
                trans('product::manufacturer.create'),
                [
                    'title' => trans('product::manufacturer.create'),
                    'label' => trans('common.save'),
                    'icon'  => 'fa-diamond',
                    'height' => 320,
                ],
                ['type'=>'success', 'size'=>'xs', 'icon' => 'plus-sign']
            ) !!}
        </div>
    </div>
    <div class="ibox ibox-table">
        <div class="ibox-title">
            <h5>{!! trans('product::manufacturer.manage_title') !!}</h5>
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
            'name' => trans('product::manufacturer.manufacturer'),
            'data_url' => route('backend.manufacturer.data'),
        ]
    )
@stop