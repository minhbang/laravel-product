<?php
namespace Minhbang\Product\Controllers\Frontend;

use Minhbang\Option\OptionableController;
use Wishlist;
use Minhbang\Product\Models\Product;
use Minhbang\Kit\Extensions\Controller;
use Minhbang\Shop\DisplayOption;

/**
 * Class ProductController
 *
 * @package Minhbang\Product\Controllers\Frontend
 */
class ProductController extends Controller
{
    use OptionableController;

    /**
     * @return array
     */
    protected function optionConfig()
    {
        return [
            'zone'  => 'shop',
            'group' => 'product',
            'class' => DisplayOption::class,
        ];
    }

    /**
     * @return \Illuminate\View\View
     * @throws \Laracasts\Presenter\Exceptions\PresenterException
     */
    public function index()
    {
        $query = Product::queryDefault();
        $products = $this->optionAppliedPaginate($query, true);
        $this->buildBreadcrumbs(['#' => trans('product::common.product')]);

        return view('product::frontend.product.index', compact('products'));
    }

    /**
     * @param \Minhbang\Product\Models\Product $product
     * @param string $slug
     *
     * @return \Illuminate\View\View
     */
    public function show($product, $slug)
    {
        if ($product->slug !== $slug) {
            abort(404);
        }
        $this->buildBreadcrumbs(
            [
                route('product.index') => trans('product::common.product'),
                '#'                    => $product->name,
            ]
        );
        $wishlist_added = Wishlist::has($product->id) ? ' added' : '';
        $tagNames = $product->tagNames();
        //Todo: config order và recently limit
        $related_products = Product::queryDefault()->except()->withAnyTag($tagNames)->orderByMatchedTag($tagNames)
            ->orderUpdated()->take(6)->get();

        return view('product::frontend.product.show', compact('product', 'wishlist_added', 'related_products'));
    }
}
