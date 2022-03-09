<?php
declare(strict_types=1);

namespace App\Proxy;

use Embed\Embed;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;


// Wraps OEmbed in a custom adapter to abstract client from vendor interface
// and adds cache
class OEmbed implements OEmbedInterface
{
    private Embed $embed;
    private CacheInterface $cache;

    public function __construct(Embed $embed, CacheInterface $cache, ContainerInterface $container)
    {
        $this->embed = $embed;
        $this->cache = $cache;
        $this->ttl = $container->getParameter('cache_ttl');
    }

    public function get(string $url)
    {
        $ttl = $this->ttl;
        $info = $this->cache->get(\sha1($url), function (ItemInterface $item) use ($url,$ttl) {
            $item->expiresAfter($ttl);
            $info = $this->embed->get($url);
            return $info;
        });
        return $info;
    }
}