<?php

declare(strict_types=1);
namespace App\Service;

use App\Proxy\OEmbedInterface;
use App\Entity\Link;


class LinkProvider
{
    protected OEmbedInterface $oEmbed;

    public function __construct(OEmbedInterface $oEmbed)
    {
        $this->oEmbed = $oEmbed;
    }

    public function get(string $url):?Link
    {
        if (!$this->oEmbed instanceof OEmbedInterface) {
            throw new \Exception('embed not defined');
        }

        if (!LinkHelpers::isValid($url)) {
            return null;
        }

        $info = $this->oEmbed->get($url);

        return LinkHelpers::extractLinkEntity($info);
    }


}