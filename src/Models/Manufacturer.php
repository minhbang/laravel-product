<?php
namespace Minhbang\LaravelProduct\Models;

use Minhbang\LaravelKit\Extensions\Model;
use Laracasts\Presenter\PresentableTrait;
use Minhbang\LaravelKit\Traits\Model\PositionTrait;
use Minhbang\LaravelKit\Traits\Model\SearchQuery;

/**
 * Class Manufacturer
 *
 * @package Minhbang\LaravelProduct
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $logo
 * @property integer $position
 * @property-read \Illuminate\Database\Eloquent\Collection|\Minhbang\LaravelProduct\Models\Product[] $products
 * @property-read mixed $url
 * @property-read mixed $resource_name
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Manufacturer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Manufacturer whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Manufacturer whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Manufacturer whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Manufacturer wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Manufacturer queryDefault()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelKit\Extensions\Model except($id = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Manufacturer searchWhere($column, $operator = '=', $fn = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Manufacturer searchWhereIn($column, $fn)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Manufacturer searchWhereBetween($column, $fn = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Manufacturer searchWhereInDependent($column, $column_dependent, $fn, $empty = [])
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelProduct\Models\Manufacturer orderPosition($direction = 'asc')
 */
class Manufacturer extends Model
{
    const LOGO_SIZE = 128;
    const LOGO_SMALL_SIZE = 48;
    const LOGO_SMALL = 'sm';
    use PresentableTrait;
    use SearchQuery;
    use PositionTrait;

    protected $presenter = 'Minhbang\LaravelProduct\Presenters\ManufacturerPresenter';
    protected $table = 'manufacturers';
    protected $fillable = ['name', 'slug'];
    public $timestamps = false;
    //Thư mục chứa hình ảnh Logo NSX
    protected $dir_images;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->dir_images = config('product.images_dir.manufacturer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('Minhbang\LaravelProduct\Models\Product');
    }

    /**
     * @param \Illuminate\Database\Query\Builder|static $query
     *
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function scopeQueryDefault($query)
    {
        return $query;
    }

    /**
     * Getter $manufacturer->url
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return '#';
    }

    /**
     * @param string $attribute
     * @param string $key
     *
     * @return array
     */
    public static function getList($attribute = 'name', $key = 'id')
    {
        return static::orderPosition()->lists($attribute, $key)->all();
    }

    /**
     * @param bool $full
     *
     * @return string
     */
    public function getLogoDirectory($full = true)
    {
        return ($full ? public_path() : '') . '/' . setting('system.public_files') . '/' . $this->dir_images;
    }

    /**
     * @param bool $small
     * @param null|string $logo
     *
     * @return string
     */
    public function getLogoPath($small = false, $logo = null)
    {
        $logo = ($small ? static::LOGO_SMALL . '-' : '') . ($logo ?: $this->logo);
        return $this->getLogoDirectory() . "/$logo";
    }

    /**
     * @param bool $small
     * @param bool $no_image
     *
     * @return string|null
     */
    public function getLogoUrl($small = false, $no_image = false)
    {
        if ($this->logo) {
            return $this->getLogoDirectory(false) . '/' . ($small ? static::LOGO_SMALL . '-' : '') . $this->logo;
        } else {
            return $no_image ? '/build/img/no-image.png' : null;
        }
    }

    /**
     * Xử lý image upload
     * - SEO tên file, thêm date time
     * - move đúng thư mục
     * - nếu edit thì xóa file cũ
     *
     * @param \Minhbang\LaravelProduct\Requests\ManufacturerRequest|\App\Http\Requests\Request $request
     */
    public function fillLogo($request)
    {
        $logo = save_image(
            $request,
            'logo',
            $this->logo ? [$this->getLogoPath(), $this->getLogoPath(true)] : null,
            $this->getLogoDirectory(),
            [
                'main'             => ['width' => static::LOGO_SIZE, 'height' => static::LOGO_SIZE],
                static::LOGO_SMALL => ['width' => static::LOGO_SMALL_SIZE, 'height' => static::LOGO_SMALL_SIZE],
            ],
            ['method' => 'insert']
        );
        $this->logo = $logo ?: $this->logo;
    }

    /**
     * Hook các events của model
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // trước khi xóa Manufacturer, sẽ xóa logo của nó
        static::deleting(
            function ($model) {
                /** @var \Minhbang\LaravelProduct\Models\Manufacturer $model */
                if ($model->logo) {
                    @unlink($model->getLogoPath());
                    @unlink($model->getLogoPath(true));
                }
            }
        );
    }
}
