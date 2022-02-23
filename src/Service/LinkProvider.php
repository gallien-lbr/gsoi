<?php


namespace App\Service;

use Embed\Embed;

class LinkProvider
{
    protected Embed $embed;

    public function __construct(Embed $embed)
    {
        $this->embed = $embed;
    }

    public function get(string $url): array
    {
        if (!$this->embed instanceof Embed) {
            throw new \Exception('embed not defined');
        }

        if (false === filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception('not a valid url');
        }

        $info = $this->embed->get($url);

        return ['title' => $info->title];
    }


}