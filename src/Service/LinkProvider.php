<?php

declare(strict_types=1);
namespace App\Service;

use App\Entity\Link;
use Embed\Embed;

class LinkProvider
{
    protected Embed $embed;

    public function __construct(Embed $embed)
    {
        $this->embed = $embed;
    }

    public function get(string $url):?Link
    {
        if (!$this->embed instanceof Embed) {
            throw new \Exception('embed not defined');
        }

        if (!LinkHelpers::isValid($url)) {
            return null;
        }

        $info = $this->embed->get($url);

        return LinkHelpers::extractLinkEntity($info);
    }


}