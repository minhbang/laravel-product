<?php
namespace Minhbang\LaravelProduct\Presenters;

use Laracasts\Presenter\Presenter;

class ManufacturerPresenter extends Presenter
{
    /**
     * @param bool $small
     * @param null|Manufacturer $manufacturer
     *
     * @return string
     */
    public function logo($small = false, $manufacturer = null)
    {
        $manufacturer = $manufacturer ?: $this->entity;
        return "<img src=\"{$manufacturer->getLogoUrl($small)}\" alt=\"{$manufacturer->name}\">";
    }

    /**
     * @return null|string
     */
    public function slider()
    {
        /** @var \Illuminate\Database\Eloquent\Collection|Manufacturer[] $manufacturers */
        $manufacturers = Manufacturer::orderPosition()->get();
        if ($manufacturers->isEmpty()) {
            return null;
        }
        $html = '<ul class="bxslider" style="display:none">';
        foreach ($manufacturers as $manufacturer) {
            $html .= "<li><a href=\"{$manufacturer->url}\">{$this->logo(false, $manufacturer)}</a></li>";
        }
        $html .= '</ul>';
        return $html;
    }
}