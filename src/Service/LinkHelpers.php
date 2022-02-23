<?php


namespace App\Service;


use App\Entity\Link;

class LinkHelpers
{
    public static function extractType(string $url): ?string
    {
        foreach (Link::PROVIDERS as $provider) {
            if (strpos($url, $provider) !== false) {
                return $provider;
            }
        }
        return null;
    }

    public static function isValid($url): bool
    {
        return \filter_var($url, FILTER_VALIDATE_URL);
    }
}