<?php
declare(strict_types=1);

namespace App\Adapter;

use Embed\Embed;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;


// Wraps OEmbed in a custom adapter to abstract client from vendor interface
// and adds cache
class OEmbedProxyProxy implements OEmbedProxyInterface
{
    private Embed $embed;
    private CacheInterface $cache;

    public function __construct(Embed $embed, CacheInterface $cache)
    {
        $this->embed = $embed;
        $this->cache = $cache;
    }

    public function get(string $url)
    {
        $info = $this->cache->get(\sha1($url), function (ItemInterface $item) use ($url) {
            $item->expiresAfter(3600);
            $info = $this->embed->get($url);
            return $info;
        });
        return $info;
    }
}