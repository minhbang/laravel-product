<?php
namespace Minhbang\LaravelProduct\Requests;

use Minhbang\LaravelKit\Extensions\Request;


class ProductRequest extends Request
{
    public $trans_prefix = 'product';
    public $rules = [
        'name'            => 'required|max:255',
        'slug'            => 'required|max:255|alpha_dash|unique:products',
        'description'     => 'required',
        'price'           => 'required|integer',
        'price_old'       => 'integer',
        'code'            => 'required|max:100|alpha_dash|unique:products',
        'size'            => 'max:255',
        'gender'          => 'integer',
        'category_id'     => 'required|integer|exists:categories,id',
        'age_id'          => 'integer|exists:categories,id',
        'manufacturer_id' => 'required|integer|exists:manufacturers,id',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** @var \Minhbang\LaravelProduct\Models\Product $product */
        if ($product = $this->route('product')) {
            //update Product
            $this->rules['slug'] .= ',slug,' . $product->id;
            $this->rules['code'] .= ',code,' . $product->id;
        } else {
            // create Product
            //$this->rules['images'] .= ':not_empty';
        }
        return $this->rules;
    }

}
