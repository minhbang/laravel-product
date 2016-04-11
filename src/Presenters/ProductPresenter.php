<?php
namespace Minhbang\Product\Presenters;

use Html;
use Wishlist;
use Minhbang\Enum\EnumPresenter as Presenter;
use Minhbang\Kit\Traits\Presenter\DatetimePresenter;

/**
 * Class ProductPresenter
 *
 * @property-read string $gender
 * @property-read string $age
 * @package Minhbang\Product\Presenters
 */
class ProductPresenter extends Presenter
{
    use DatetimePresenter;

    function __construct($entity)
    {
        parent::__construct($entity);
    }

    /**
     * @return mixed
     */
    public function is_special()
    {
        return Html::yesNoLabel($this->entity->is_special, trans('common.yes'), trans('common.no'));
    }

    /**
     * @return string
     */
    public function tagsHtml()
    {
        if ($tags = $this->entity->tagNames()) {
            $result = implode('</span><span class="label label-primary">', $tags);

            return "<span class=\"label label-primary\">$result</span>";
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function info()
    {
        return "
<ul class=\"list-unstyled properties\">
    <li><span>" . trans('product::common.code') . ":</span> {$this->entity->code}</li>
    <li><span>" . trans('product::common.manufacturer_id') . ":</span> {$this->manufacturer()}</li>
    <li><span>" . trans('product::common.category_id') . ":</span> {$this->category()}</li>
    <li><span>" . trans('product::common.gender_id') . ":</span> {$this->gender}</li>
    <li><span>" . trans('product::common.age_id') . ":</span> {$this->age}</li>
    <li><span>" . trans('product::common.size') . ":</span> {$this->entity->size}</li>
</ul>";
    }

    /**
     * @param string $sign
     * @param null|string $wrapper
     *
     * @return null|string
     */
    public function price($sign = '', $wrapper = null)
    {
        return price_format($this->entity->price, $sign, $wrapper, false, config('product.decimals'));
    }

    /**
     * @param string $sign
     * @param null|string $wrapper
     *
     * @return null|string
     */
    public function price_old($sign = '', $wrapper = null)
    {
        return price_format($this->entity->price_old, $sign, $wrapper, false, config('product.decimals'));
    }

    /**
     * @return string|null
     */
    public function category()
    {
        return $this->entity->category ? $this->entity->category->title : null;
    }

    /**
     * @return string|null
     */
    public function manufacturer()
    {
        return $this->entity->manufacturer ? $this->entity->manufacturer->name : null;
    }

    /**
     * @return string
     */
    public function link()
    {
        return "<a href=\"{$this->entity->url}\">{$this->entity->name}</a>";
    }

    /**
     * Link preview product
     *
     * @return string
     */
    public function linkPreview()
    {
        $url = route('backend.product.show', ['product' => $this->entity->id]);

        return "<a href=\"{$url}\">{$this->entity->name}</a>";
    }

    /**
     * @param string|null $class
     * @param bool $sm
     * @param bool $title
     *
     * @return string
     */
    public function featured_image($class = 'img-responsive', $sm = false, $title = false)
    {
        $src = $this->entity->featuredImageUrl($sm);
        $class = $class ? " class =\"$class\"" : '';
        $html = $title ? "<div class=\"title\">{$this->entity->name}</div>" : '';
        $sm = $sm ? '_sm' : '';
        $width = $this->entity->config['featured_image']["width{$sm}"];
        $height = $this->entity->config['featured_image']["height{$sm}"];

        return "<img{$class} src=\"$src\" title=\"{$this->entity->name}\" ath=\"{$this->entity->name}\" width=\"$width\" height=\"$height\" />{$html}";
    }

    public function lightbox_featured_image()
    {
        $src = $this->entity->featuredImageUrl(false);
        $src_sm = $this->entity->featuredImageUrl(true);

        return "<a href=\"{$src}\" data-lightbox=\"product{$this->entity->id}\"><img src=\"{$src_sm}\"></a>";
    }

    public function lightbox_images()
    {
        $id = $this->entity->id;
        $images = $this->entity->linkedImages;
        $html = '';
        foreach ($images as $image) {
            $html .= "<a href=\"{$image->src}\" data-lightbox=\"product{$id}\" data-title=\"{$image->title}\"><img src=\"{$image->thumb}\"/></a>";
        }

        return "<div class=\"lightbox-images\">$html</div>";
    }

    /**
     * @return string
     */
    public function slider_images()
    {
        $id = $this->entity->id;
        $images = $this->entity->linkedImages;
        $html = '';
        foreach ($images as $image) {
            $html .= "<li><a href=\"{$image->src}\" data-lightbox=\"product-{$id}\" data-title=\"{$image->title}\"><img src=\"{$image->thumb}\"></a></li>";
        }
        if ($html) {
            $html = "<ul class=\"slider-images bxslider\" style=\"display:none\">{$html}</ul>";
        }

        return $html;
    }

    /**
     * Render sản phẩm dạng column
     *
     * @return string
     */
    public function htmlCol()
    {
        $wishlist_label = trans('shop::cart.wishlist');
        $wishlist_url = route('wishlist.update', ['product' => $this->entity->id]);
        $wishlist_added = Wishlist::has($this->entity->id) ? ' added' : '';
        $compare_label = trans('shop::cart.compare');
        $compare_url = route('wishlist.compare', ['product' => $this->entity->id]);
        $currency = config('product.currency_short');
        return <<<"HTML"
<div class="product-col cart-item" data-id="{$this->entity->id}">
    <div class="image"><a href="{$this->entity->url}">{$this->featured_image()}</a></div>
    <div class="caption">
        <h4><a href="{$this->entity->url}" class="name">{$this->entity->name}</a></h4>
        <div class="price">
            {$this->price_old($currency, 'price-old')}
            {$this->price($currency, 'price-new')}
        </div>
        <div class="cart-button">
            <a href="{$wishlist_url}" data-toggle="tooltip" title="{$wishlist_label}" class="btn btn-wishlist{$wishlist_added}" data-action="wishlist-update">
                <i class="fa fa-heart"></i>
            </a>
            <a href="{$compare_url}" data-toggle="tooltip" title="{$compare_label}" class="btn btn-compare">
            	<i class="fa fa-bar-chart-o"></i>
            </a>
            {$this->htmlBtnCart()}
        </div>
    </div>
</div>
HTML;
    }

    /**
     * @param integer $index
     *
     * @return string
     */
    public function htmlWishlistRow($index = null)
    {
        /** @var \Minhbang\Product\Models\Product $product */
        $product = $this->entity;
        if ($index) {
            $remove_url = route('wishlist.update', ['product' => $product->id]);
            $remove_title = trans('common.remove');
            $remove_link = "<a href=\"{$remove_url}\" data-toggle=\"tooltip\" data-action=\"wishlist-update\" title=\"{$remove_title}\" ><i class=\"fa fa-times\"></i></a>";
        } else {
            $remove_link = '';
        }
        $currency = config('product.currency_short');

        return <<<"HTML"
<tr id="row-{$index}" class="cart-item" data-id="{$product->id}">
    <td class="min-width text-right">{$index}</td>
    <td class="min-width image">{$this->featured_image('', true)}</td>
    <td class="min-width">{$product->code}</td>
    <td>
        <a href="{$product->url}" class="name">{$product->name}</a>
        <div class="cart-button">{$this->htmlBtnCart()}</div>
    </td>
    <td class="min-width">{$this->manufacturer()}</td>
    <td class="min-width price">
        {$this->price($currency, 'price-new')}<br>
        {$this->price_old($currency, 'price-old')}
    </td>
    <td class="min-width text-center">{$remove_link}</td>
</tr>
HTML;
    }

    /**
     * @return string
     */
    public function htmlBtnCart()
    {
        $cart_label = trans('shop::cart.add');
        $cart_url = route('cart.add', ['product' => $this->entity->id]);

        return "<a href=\"{$cart_url}\" class=\"btn btn-cart\" data-action=\"cart-add\">
                {$cart_label} <i class=\"fa fa-shopping-cart\"></i>
            </a>";
    }
}