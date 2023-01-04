<?php
namespace App\Twig;

use App\Twig\TwigArray;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('array_shuffle', [TwigArray::class, 'shuffle']),
        ];
    }
}
?>