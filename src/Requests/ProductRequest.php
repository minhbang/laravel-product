<?php
namespace Minhbang\Product\Requests;

use Minhbang\Locale\TranslatableRequest;

class ProductRequest extends TranslatableRequest
{
    protected $trans_prefix = 'product::common';

    protected $rules = [
        'name'            => 'required|max:255',
        'slug'            => 'required|max:255|alpha_dash',
        'description'     => 'required',
        'price'           => 'required|integer',
        'price_old'       => 'integer',
        'code'            => 'required|max:100|alpha_dash|unique:products',
        'size'            => 'max:255',
        'gender_id'       => 'integer',
        'category_id'     => 'required|integer|exists:categories,id',
        'age_id'          => 'integer|exists:categories,id',
        'manufacturer_id' => 'required|integer|exists:manufacturers,id',
    ];

    protected $translatable = ['name', 'slug', 'description'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** @var \Minhbang\Product\Models\Product $product */
        if ($product = $this->route('product')) {
            //update Product
            $this->rules['code'] .= ',code,' . $product->id;
        } else {
            // create Product
            //$this->rules['images'] .= ':not_empty';
        }

        return $this->rules;
    }

}
