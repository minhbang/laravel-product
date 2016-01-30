<?php
namespace Minhbang\Product\Models;

use DB;
use Minhbang\Category\Categorized;
use Minhbang\Enum\EnumContract;
use Minhbang\Enum\HasEnum;
use Minhbang\Image\ImageableModel as Model;
use Laracasts\Presenter\PresentableTrait;
use Minhbang\User\Support\UserQuery;
use Minhbang\Kit\Traits\Model\SearchQuery;
use Minhbang\Kit\Traits\Model\FeaturedImage;
use Minhbang\Kit\Traits\Model\DatetimeQuery;
use Minhbang\Kit\Traits\Model\PositionTrait;
use Minhbang\Kit\Traits\Model\TaggableTrait;

/**
 * Class Product
 *
 * @package Minhbang\Product\Models
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property integer $price
 * @property integer $price_old
 * @property string $code
 * @property string $size
 * @property integer $gender_id
 * @property integer $age_id
 * @property integer $hit
 * @property integer $user_id
 * @property integer $category_id
 * @property integer $manufacturer_id
 * @property string $featured_image
 * @property integer $position
 * @property boolean $is_special
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Minhbang\Product\Models\Manufacturer $manufacturer
 * @property-read mixed $url
 * @property mixed $linked_image_ids
 * @property-read mixed $linked_image_ids_original
 * @property-read \Illuminate\Database\Eloquent\Collection|\Minhbang\Image\ImageModel[] $images
 * @property mixed $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\Conner\Tagging\Tagged[] $tagged
 * @property-read \Minhbang\User\User $user
 * @property-read \Minhbang\Category\Item $category
 * @property-read string $category_title
 * @property-read mixed $featured_image_url
 * @property-read mixed $featured_image_sm_url
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product queryDefault()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product special()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Kit\Extensions\Model except($id = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Kit\Extensions\Model whereAttributes($attributes)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Kit\Extensions\Model findText($column, $text)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product related()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product orderByMatchedTag($tagNames, $direction = 'desc')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product withAllTags($tagNames)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product withAnyTag($tagNames)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product orderCreated($direction = 'desc')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product orderUpdated($direction = 'desc')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product period($start = null, $end = null, $field = 'created_at', $end_if_day = false, $is_month = false)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product today($field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product yesterday($same_time = false, $field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product thisWeek($field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product thisMonth($field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product searchKeyword($keyword, $columns = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product searchWhere($column, $operator = '=', $fn = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product searchWhereIn($column, $fn)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product searchWhereBetween($column, $fn = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product searchWhereInDependent($column, $column_dependent, $fn, $empty = [])
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product notMine()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product mine()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product withAuthor()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product categorized($category = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product withCategoryTitle()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product orderPosition($direction = 'asc')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Product\Models\Product withEnumTitles()
 */
class Product extends Model implements EnumContract
{
    const GENDER_ALL    = 0;
    const GENDER_MALE   = 1;
    const GENDER_FEMALE = 2;

    use TaggableTrait;
    use DatetimeQuery;
    use SearchQuery;
    use UserQuery;
    use Categorized;
    use PositionTrait;
    use PresentableTrait;
    use FeaturedImage;
    use HasEnum;

    protected $presenter = 'Minhbang\Product\Presenters\ProductPresenter';
    protected $table = 'products';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'price_old',
        'code',
        'size',
        'gender_id',
        'age_id',
        'category_id',
        'manufacturer_id',
        'tags',
        'linked_image_ids',
    ];

    protected $searchable = ['name', 'description'];

    /**
     * Chuyển đổi search params 'key' thành 'column name',
     * ===> Gọn + dấu 'column name' thật trên url
     *
     * @var array
     */
    public static $searchable_keys = [
        'c' => 'category_id',
        'm' => 'manufacturer_id',
        'g' => 'gender_id',
        'a' => 'age_id',
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
     * Nhà sản xuất
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manufacturer()
    {
        return $this->belongsTo('Minhbang\Product\Models\Manufacturer');
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
     * @param \Minhbang\Category\Item $category
     * @param int $limit
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function topOf($category, $limit = 6)
    {
        return static::orderPosition()->categorized($category)->take($limit)->get();
    }

    /**
     * @return string
     */
    public function enumGroup()
    {
        return 'product';
    }

    /**
     * @return string
     */
    public function enumGroupTitle()
    {
        return trans('product::common.product');
    }

    /**
     * Các attributes có giá trị là các Enum
     *
     * @return string
     */
    protected function enumAttributes()
    {
        return [
            'gender_id' => trans('product::common.gender_id'),
            'age_id'    => trans('product::common.age_id'),
        ];
    }

    /**
     * Danh sách enum attributes KHÔNG cho phép TẠO MỚI khi edit Model sử dụng
     * Chỉ được phép thêm trong trang quản lý enum,
     *
     * @return array
     */
    protected function enumGuarded()
    {
        return ['gender_id', 'age_id'];
    }
}
