<?php
declare(strict_types=1);
namespace App\Adapter;

use Embed\Embed;

// Wraps OEmbed in a custom adapter to abstract client from vendor interface
class OEmbedAdapter implements OEmbedInterface
{
    private Embed $embed;

    public function __construct(Embed $embed)
    {
        $this->embed = $embed;
    }
    public function get(string $url){
        return $this->embed->get($url);
    }
}