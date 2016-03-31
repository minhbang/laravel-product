<?php
namespace Minhbang\Product\Models;

use Eloquent;

/**
 * Class ProductTranslation
 *
 * @package Minhbang\Product\Models
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property integer $product_id
 * @property string $locale
 */
class ProductTranslation extends Eloquent
{
    public $timestamps = false;
    protected $table = 'product_translations';
    protected $fillable = ['name', 'slug', 'description'];
}
