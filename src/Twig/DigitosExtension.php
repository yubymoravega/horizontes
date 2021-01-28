<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DigitosExtension extends AbstractExtension
{
   
    public function getFilters()
    {
        return [
            new TwigFilter('digitos', [$this, 'digitos']),
        ];
    }

    public function digitos($number)
    {
        return number_format($number, 2, '.', ' ') ;
    }

    
}