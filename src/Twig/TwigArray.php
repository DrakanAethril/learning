<?php
namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;

class TwigArray implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // this simple example doesn't define any dependency, but in your own
        // extensions, you'll need to inject services using this constructor
    }

    public function shuffle(array $toShuffle): array
    {
        
        $keys = array_keys($toShuffle); 
        shuffle($keys); 
        $random = array(); 
        foreach ($keys as $key) { 
            $random[$key] = $toShuffle[$key]; 
        }
        return $random;
    }
}
?>