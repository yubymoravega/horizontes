<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
   
    public function getFilters()
    {
        return [
            new TwigFilter('decodeJson', [$this, 'decodeJson']),
        ];
    }

    public function decodeJson($json)
    {
        return json_decode($json, true);
    }

    
}