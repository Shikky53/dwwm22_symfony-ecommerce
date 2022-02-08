<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PriceFormatExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('priceFormatEuro', [$this, 'priceFormatEuro']),
        ];
    }

    public function priceFormatEuro($value): string
    {
        $value = $value / 100;

        $value = number_format($value,2,',',' ');

        return $value . ' €';
    }
}
