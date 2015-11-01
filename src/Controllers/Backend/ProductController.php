<?php
namespace Minhbang\LaravelProduct\Controllers\Backend;

use Minhbang\LaravelImage\ImageModel;
use Minhbang\LaravelKit\Traits\Controller\PositionActions;
use Minhbang\LaravelProduct\Models\Manufacturer;
use Minhbang\LaravelProduct\Models\Product;
use Datatable;
use Html;
use Minhbang\LaravelProduct\Requests\ProductRequest;
use Minhbang\LaravelKit\Extensions\BackendController;
use Request;
use Session;

/**
 * Class ProductController
 *
 * @package App\Http\Controllers\Backend
 */
class ProductController extends BackendController
{
    use PositionActions;

    /** @var  \Minhbang\LaravelCategory\Category */
    protected $categoryManager;

    public function __construct()
    {
        parent::__construct(config('product.middlewares.backend.product'));
        $this->categoryManager = app('category')->manage('product-backend');
    }

    /**
     * Danh sách Product theo định dạng của Datatables.
     *
     * @return \Datatable JSON
     */
    public function data()
    {
        /** @var \Minhbang\LaravelProduct\Models\Product $query */
        $query = Product::queryDefault()->orderPosition()->withCategoryTitle();
        if (Request::has('search_form')) {
            $query->searchWhere('products.category_id')
                ->searchWhere('products.age_id')
                ->searchWhereBetween('products.created_at', 'mb_date_vn2mysql')
                ->searchWhereBetween('products.updated_at', 'mb_date_vn2mysql');
        }
        return Datatable::query($query)
            ->addColumn(
                'index',
                function (Product $model) {
                    return $model->id;
                }
            )
            ->addColumn(
                'code',
                function (Product $model) {
                    return $model->code;
                }
            )
            ->addColumn(
                'name',
                function (Product $model) {
                    return $model->name;
                }
            )
            ->addColumn(
                'price',
                function (Product $model) {
                    return $model->present()->price;
                }
            )
            ->addColumn(
                'price_old',
                function (Product $model) {
                    return $model->present()->price_old;
                }
            )
            ->addColumn(
                'category',
                function (Product $model) {
                    return $model->category_title;
                }
            )
            ->addColumn(
                'actions',
                function (Product $model) {
                    return Html::tableActions(
                        'backend/product',
                        $model->id,
                        $model->name,
                        trans('product::common.product'),
                        [
                            'renderShow' => 'link',
                            'renderEdit' => 'link',
                        ]
                    );
                }
            )
            ->searchColumns('products.title', 'categories.title')
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
            'id'              => 'product-manage',
            'class'           => 'table-sortable',
            'row_index'       => true,
            'row_reorder'     => true,
            'row_reorder_url' => route('backend.product.order'),
        ];
        $options = [
            'aoColumnDefs' => [
                ['sClass' => 'min-width', 'aTargets' => [1, -1, -2]],
                ['sClass' => 'min-width column-number', 'aTargets' => [0, -3, -4]],
            ],
        ];
        $table = Datatable::table()
            ->addColumn(
                '#',
                trans('product::common.code_th'),
                trans('product::common.name'),
                trans('product::common.price'),
                trans('product::common.price_old'),
                trans('product::common.category_id'),
                trans('common.actions')
            )
            ->setOptions($options)
            ->setCustomValues($tableOptions);

        $categories = $this->categoryManager->of('product')->selectize();
        $ages = $this->categoryManager->of('age')->selectize();;
        $genders = (new Product())->itemAlias('Gender');
        $this->buildHeading(trans('product::common.manage'), 'fa-cubes', ['#' => trans('product::common.product')]);
        return view(
            'product::backend.product.index',
            compact('tableOptions', 'options', 'table', 'categories', 'genders', 'ages')
        );
    }

    /**
     * @return \Illuminate\View\View
     * @throws \Laracasts\Presenter\Exceptions\PresenterException
     */
    public function create()
    {
        $product = new Product();
        $product->code = 'SP' . (Product::max('id') + 1);

        $url = route('backend.product.store');
        $method = 'post';
        $categories = $this->categoryManager->of('product')->selectize();
        $ages = $this->categoryManager->of('age')->selectize();
        $genders = $product->itemAlias('Gender');
        $manufacturers = Manufacturer::getList();
        $tags = '';
        $all_product_tags = Product::allTagNames();
        $all_image_tags = ImageModel::allTagNames();
        $images = '[]';
        $this->buildHeading(
            trans('common.create_object', ['name' => trans('product::common.product')]),
            'plus-sign',
            [
                route('backend.product.index') => trans('product::common.product'),
                '#'                            => trans('common.create'),
            ]
        );
        return view(
            'product::backend.product.form',
            compact('product', 'url', 'method', 'categories', 'genders', 'ages', 'manufacturers', 'tags', 'all_product_tags', 'all_image_tags', 'images')
        );
    }

    /**
     * @param \Minhbang\LaravelProduct\Requests\ProductRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->fill($request->all());
        $product->fillFeaturedImage($request);
        $product->fillNextPosition();
        $product->user_id = user('id');
        $product->is_special = empty($request->get('is_special')) ? 0 : 1;
        $product->save();
        Session::flash(
            'message',
            [
                'type'    => 'success',
                'content' => trans('common.create_object_success', ['name' => trans('product::common.product')]),
            ]
        );
        return redirect(route('backend.product.index'));
    }

    /**
     * @param \Minhbang\LaravelProduct\Models\Product $product
     *
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        $this->buildHeading(
            trans('common.object_details_view', ['name' => trans('product::common.product')]),
            'fa-list-alt',
            [route('backend.product.index') => trans('product::common.product'), '#' => trans('common.detail')],
            [
                [
                    route('backend.product.edit', ['product' => $product->id]),
                    trans('common.edit'),
                    ['icon' => 'edit', 'type' => 'success'],
                ],
            ]
        );
        return view('product::backend.product.show', compact('product'));
    }

    /**
     * @param \Minhbang\LaravelProduct\Models\Product $product
     *
     * @return \Illuminate\View\View
     * @throws \Laracasts\Presenter\Exceptions\PresenterException
     */
    public function edit(Product $product)
    {
        $url = route('backend.product.update', ['product' => $product->id]);
        $method = 'put';
        $categories = $this->categoryManager->of('product')->selectize();
        $ages = $this->categoryManager->of('age')->selectize();
        $genders = $product->itemAlias('Gender');
        $manufacturers = Manufacturer::getList();
        $tags = implode(',', $product->tagNames());
        $all_product_tags = Product::allTagNames();
        $all_image_tags = ImageModel::allTagNames();
        $images = $product->jsonImages();
        $this->buildHeading(
            trans('common.update_object', ['name' => trans('product::common.product')]),
            'edit',
            [
                route('backend.product.index') => trans('product::common.product'),
                '#'                            => trans('common.edit'),
            ]
        );
        return view(
            'product::backend.product.form',
            compact('product', 'url', 'method', 'categories', 'genders', 'ages', 'manufacturers', 'tags', 'all_product_tags', 'all_image_tags', 'images')
        );
    }

    /**
     * @param \Minhbang\LaravelProduct\Requests\ProductRequest $request
     * @param \Minhbang\LaravelProduct\Models\Product $product
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->fill($request->all());
        $product->fillFeaturedImage($request);
        $product->is_special = empty($request->get('is_special')) ? 0 : 1;
        $product->save();
        Session::flash(
            'message',
            [
                'type'    => 'success',
                'content' => trans('common.update_object_success', ['name' => trans('product::common.product')]),
            ]
        );
        return redirect(route('backend.product.index'));
    }

    /**
     * @param \Minhbang\LaravelProduct\Models\Product $product
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(
            [
                'type'    => 'success',
                'content' => trans('common.delete_object_success', ['name' => trans('product::common.product')]),
            ]
        );
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function positionModel($id)
    {
        return Product::find($id);
    }

    /**
     * @return string
     */
    protected function positionName()
    {
        return trans('product::common.product');
    }
}
