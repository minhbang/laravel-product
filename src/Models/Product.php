<?php
namespace Minhbang\LaravelProduct\Models;

use DB;
use Minhbang\LaravelImage\ImageableModel as Model;
use Laracasts\Presenter\PresentableTrait;
use Minhbang\LaravelCategory\CategoryQuery;
use Minhbang\LaravelKit\Traits\Model\HasAlias;
use Minhbang\LaravelUser\Support\UserQuery;
use Minhbang\LaravelKit\Traits\Model\SearchQuery;
use Minhbang\LaravelKit\Traits\Model\FeaturedImage;
use Minhbang\LaravelKit\Traits\Model\DatetimeQuery;
use Minhbang\LaravelKit\Traits\Model\PositionTrait;
use Minhbang\LaravelKit\Traits\Model\TaggableTrait;

/**
 * Class Product
 *
 * @package Minhbang\LaravelProduct\Models
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property integer $price
 * @property integer $price_old
 * @property string $code
 * @property string $size
 * @property integer $gender
 * @property integer $hit
 * @property integer $user_id
 * @property integer $category_id
 * @property integer $age_id
 * @property integer $manufacturer_id
 * @property string $featured_image
 * @property integer $position
 * @property boolean $is_special
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read string $category_title
 * @property-read \Minhbang\LaravelCategory\Category $age
 * @property-read \Minhbang\LaravelProduct\Models\Manufacturer $manufacturer
 * @property-read mixed $url
 * @property-read mixed $resource_name
 * @property mixed $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\Conner\Tagging\Tagged[] $tagged
 * @property-read \Minhbang\LaravelUser\User $user
 * @property-read \Minhbang\LaravelCategory\CategoryItem $category
 * @property-read mixed $featured_image_url
 * @property-read mixed $featured_image_sm_url
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product wherePriceOld($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereSize($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereHit($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereAgeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereManufacturerId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereFeaturedImage($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereIsSpecial($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product queryDefault()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product special()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelKit\Extensions\Model except($id = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product related()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product orderByMatchedTag($tagNames, $direction = 'desc')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product withAllTags($tagNames)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product withAnyTag($tagNames)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product orderCreated($direction = 'desc')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product orderUpdated($direction = 'desc')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product period($start = null, $end = null, $field = 'created_at', $end_if_day = false, $is_month = false)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product today($field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product yesterday($same_time = false, $field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product thisWeek($field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product thisMonth($field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product searchWhere($column, $operator = '=', $fn = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product searchWhereIn($column, $fn)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product searchWhereBetween($column, $fn = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product searchWhereInDependent($column, $column_dependent, $fn, $empty = [])
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product notMine()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product mine()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product withAuthor()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product categorized($category = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product withCategoryTitle()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Product orderPosition($direction = 'asc')
 */
class Product extends Model
{
    const GENDER_ALL = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    use TaggableTrait;
    use DatetimeQuery;
    use SearchQuery;
    use UserQuery;
    use CategoryQuery;
    use PositionTrait;
    use PresentableTrait;
    use FeaturedImage;
    use HasAlias;

    protected $presenter = 'Minhbang\LaravelProduct\Presenters\ProductPresenter';
    protected $table = 'products';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'price_old',
        'code',
        'size',
        'gender',
        'category_id',
        'age_id',
        'manufacturer_id',
        'tags',
        'linked_image_ids',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->config([
            'featured_image' => config('product.featured_image'),
        ]);
    }

    /**
     * @return array
     */
    public function imageables()
    {
        return [];
    }


    /**
     * @return array
     */
    public function aliases()
    {
        return [
            'Gender' => [
                static::GENDER_ALL    => trans('product::common.gender.all'),
                static::GENDER_MALE   => trans('product::common.gender.male'),
                static::GENDER_FEMALE => trans('product::common.gender.female'),
            ],
        ];
    }

    /**
     * Hook các events của model
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        // trước khi xóa Product
        static::deleting(
            function ($model) {
                /** @var static $model */
                $model->deleteFeaturedImage();
            }
        );
    }

    /**
     * Danh mục độ tuổi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function age()
    {
        return $this->belongsTo('Minhbang\LaravelCategory\CategoryItem');
    }

    /**
     * Nhà sản xuất
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manufacturer()
    {
        return $this->belongsTo('Minhbang\LaravelProduct\Models\Manufacturer');
    }

    /**
     * @return string
     */
    public function jsonImages()
    {
        return $this->exists ?
            json_encode(
                $this->arrayLinkedImages(['id', 'title', 'tag' => 'tags', 'url' => 'src', 'thumb_4x', 'thumb', 'size'])
            ) : '[]';
    }

    /**
     * Url xem product
     *
     * @return string $product->url
     */
    public function getUrlAttribute()
    {
        return route('product.show', ['product' => $this->id, 'slug' => $this->slug]);
    }

    /**
     * @param $value
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = clean($value);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeQueryDefault($query)
    {
        return $query->select("{$this->table}.*");
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeSpecial($query)
    {
        return $query->where("{$this->table}.is_special", '>', 0);
    }

    /**
     * @return bool
     */
    public function isSpecial()
    {
        return $this->is_special;
    }

    /**
     * Lấy tất cả Product trừ self
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOther()
    {
        return static::queryDefault()->except($this->id)->get();
    }

    /**
     * Tăng số lần đọc, +1 hit
     */
    public function updateHit()
    {
        return DB::table($this->table)->where('id', '=', $this->id)->increment('hit');
    }

    /**
     * @param \Minhbang\LaravelCategory\CategoryItem $category
     * @param int $limit
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function topOf($category, $limit = 6)
    {
        return static::orderPosition()->categorized($category)->take($limit)->get();
    }
}
