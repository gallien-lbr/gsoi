<?php

declare(strict_types=1);
namespace App\Service;

use App\Adapter\OEmbedProxyInterface;
use App\Entity\Link;


class LinkProvider
{
    protected OEmbedProxyInterface $oEmbed;

    public function __construct(OEmbedProxyInterface $oEmbed)
    {
        $this->oEmbed = $oEmbed;
    }

    public function get(string $url):?Link
    {
        if (!$this->oEmbed instanceof OEmbedProxyInterface) {
            throw new \Exception('embed not defined');
        }

        if (!LinkHelpers::isValid($url)) {
            return null;
        }

        $info = $this->oEmbed->get($url);

        return LinkHelpers::extractLinkEntity($info);
    }


}