<?php
namespace Minhbang\LaravelProduct\Controllers\Frontend;

use Wishlist;
use Minhbang\LaravelProduct\Models\Product;
use Minhbang\LaravelKit\Extensions\Controller;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\View\View
     * @throws \Laracasts\Presenter\Exceptions\PresenterException
     */
    public function index()
    {
        // Todo: options products per page
        $products = Product::orderPosition()->paginate(12);
        $this->buildBreadcrumbs(['#' => trans('product::common.product')]);
        return view('product::frontend.product.index', compact('products'));
    }

    /**
     * @param \Minhbang\LaravelProduct\Models\Product $product
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
        $related_products = Product::queryDefault()->withAnyTag($tagNames)->orderByMatchedTag($tagNames)->orderUpdated()
            ->take(6)->get();
        return view('product::frontend.product.show', compact('product', 'wishlist_added', 'related_products'));
    }
}
