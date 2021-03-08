<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class JsonDecode extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('jsonDecode', [$this, 'jsonDecode']),
        ];
    }

    public function jsonDecode($json)
    {
       
        return \json_decode($json);
    }  
}