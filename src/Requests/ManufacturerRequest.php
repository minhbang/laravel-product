<?php
namespace Minhbang\Product\Requests;

use Minhbang\Kit\Extensions\Request;

/**
 * Class ManufacturerRequest
 *
 * @package Minhbang\Product\Requests
 */
class ManufacturerRequest extends Request
{
    public $trans_prefix = 'product::manufacturer';
    public $rules = [
        'name' => 'required|max:128',
        'slug' => 'required|max:128',
        'logo' => 'image',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules['logo'] .= '|max:' . setting('system.max_image_size') * 1024;
        /** @var \Minhbang\Product\Models\Manufacturer $manufacturer */
        if ($manufacturer = $this->route('manufacturer')) {
            //update Manufacturer
        } else {
            // create Manufacturer
            $this->rules['logo'] .= '|required';
        }
        return $this->rules;
    }

}
