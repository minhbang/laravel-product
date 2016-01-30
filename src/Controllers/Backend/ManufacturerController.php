<?php
namespace Minhbang\Product\Controllers\Backend;

use Minhbang\Kit\Extensions\BackendController;
use Minhbang\Product\Models\Manufacturer;
use Datatable;
use Html;
use Minhbang\Product\Requests\ManufacturerRequest;
use Minhbang\Kit\Traits\Controller\PositionActions;

/**
 * Class ManufacturerController
 *
 * @package App\Http\Controllers\Backend
 */
class ManufacturerController extends BackendController
{
    use PositionActions;

    /**
     * Danh sách Manufacturer theo định dạng của Datatables.
     *
     * @return \Datatable JSON
     */
    public function data()
    {
        /** @var Manufacturer $query */
        $query = Manufacturer::orderPosition();

        return Datatable::query($query)
            ->addColumn(
                'index',
                function (Manufacturer $model) {
                    return $model->id;
                }
            )
            ->addColumn(
                'logo',
                function (Manufacturer $model) {
                    return $model->present()->logo(true);
                }
            )
            ->addColumn(
                'name',
                function (Manufacturer $model) {
                    return $model->name;
                }
            )
            ->addColumn(
                'actions',
                function (Manufacturer $model) {
                    return Html::tableActions(
                        'backend.manufacturer',
                        ['manufacturer' => $model->id],
                        $model->name,
                        trans('product::manufacturer.manufacturer'),
                        [
                            'heightEdit' => 320,
                            'heightShow' => 320,
                        ]
                    );
                }
            )
            ->searchColumns('manufacturers.name')
            ->make();
    }

    /**
     * @return \Illuminate\View\View
     * @throws \Exception
     * @throws \Laracasts\Presenter\Exceptions\PresenterException
     */
    public function index()
    {
        $tableOptions = [
            'id'              => 'manufacturer-manage',
            'class'           => 'table-sortable',
            'row_index'       => true,
            'row_reorder'     => true,
            'row_reorder_url' => route('backend.manufacturer.order'),
        ];
        $options = [
            'aoColumnDefs' => [
                ['sClass' => 'min-width', 'aTargets' => [0, -1]],
                ['sClass' => 'min-width column-image', 'aTargets' => [1]],
            ],
        ];
        $table = Datatable::table()
            ->addColumn(
                '#',
                trans('product::manufacturer.logo'),
                trans('product::manufacturer.name'),
                trans('common.actions')
            )
            ->setOptions($options)
            ->setCustomValues($tableOptions);
        $this->buildHeading(trans('product::manufacturer.manage'), 'fa-diamond', ['#' => trans('product::manufacturer.manufacturer')]);

        return view('product::backend.manufacturer.index', compact('tableOptions', 'options', 'table'));
    }

    /**
     * @return \Illuminate\View\View
     * @throws \Laracasts\Presenter\Exceptions\PresenterException
     */
    public function create()
    {
        $manufacturer = new Manufacturer();
        $url = route('backend.manufacturer.store');
        $method = 'post';
        $logo_size = Manufacturer::LOGO_SIZE;

        return view('product::backend.manufacturer.form', compact('manufacturer', 'url', 'method', 'logo_size'));
    }

    /**
     * @param \Minhbang\Product\Requests\ManufacturerRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function store(ManufacturerRequest $request)
    {
        $manufacturer = new Manufacturer();
        $manufacturer->fill($request->all());
        $manufacturer->fillLogo($request);
        $manufacturer->fillNextPosition();
        $manufacturer->save();

        return view(
            '_modal_script',
            [
                'message'     => [
                    'type'    => 'success',
                    'content' => trans('app.create_object_success', ['name' => trans('product::manufacturer.manufacturer')]),
                ],
                'reloadTable' => 'manufacturer-manage',
            ]
        );

    }

    /**
     * @param \Minhbang\Product\Models\Manufacturer $manufacturer
     *
     * @return \Illuminate\View\View
     */
    public function show(Manufacturer $manufacturer)
    {
        return view('product::backend.manufacturer.show', compact('manufacturer'));
    }

    /**
     * @param \Minhbang\Product\Models\Manufacturer $manufacturer
     *
     * @return \Illuminate\View\View
     */
    public function edit(Manufacturer $manufacturer)
    {
        $url = route('backend.manufacturer.update', ['manufacturer' => $manufacturer->id]);
        $method = 'put';
        $logo_size = Manufacturer::LOGO_SIZE;

        return view('product::backend.manufacturer.form', compact('manufacturer', 'url', 'method', 'logo_size'));
    }

    /**
     * @param \Minhbang\Product\Requests\ManufacturerRequest $request
     * @param \Minhbang\Product\Models\Manufacturer $manufacturer
     *
     * @return \Illuminate\View\View
     */
    public function update(ManufacturerRequest $request, Manufacturer $manufacturer)
    {
        $manufacturer->fill($request->all());
        $manufacturer->fillLogo($request);
        $manufacturer->save();

        return view(
            '_modal_script',
            [
                'message'     => [
                    'type'    => 'success',
                    'content' => trans('common.update_object_success', ['name' => trans('product::manufacturer.manufacturer')]),
                ],
                'reloadTable' => 'manufacturer-manage',
            ]
        );
    }

    /**
     * @param \Minhbang\Product\Models\Manufacturer $manufacturer
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();

        return response()->json(
            [
                'type'    => 'success',
                'content' => trans('common.delete_object_success', ['name' => trans('product::manufacturer.manufacturer')]),
            ]
        );
    }

    /**
     * @param integer $id
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function positionModel($id)
    {
        return Manufacturer::find($id);
    }

    /**
     * @return string
     */
    protected function positionName()
    {
        return trans('product::manufacturer.manufacturer');
    }
}
