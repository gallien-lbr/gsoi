<?php


namespace App\Service;


use App\Entity\Link;
use App\Enum\ProviderEnum;

class LinkHelpers
{
    public static function extractProvider(string $inputProvider): ?string
    {
        $inputProvider = strtolower($inputProvider);
        foreach (ProviderEnum::PROVIDERS as $provider) {
            if (strpos($provider, $inputProvider) !== false) {
                return $provider;
            }
        }
        return null;
    }

    public static function isValid($url): bool
    {
        return \filter_var($url, FILTER_VALIDATE_URL);
    }

    public static function extractLinkEntity($info): Link
    {
        $link = new Link();
        $link->setProperties(
        [
            'width' => $info->code->width,
            'height' => $info->code->height,
            'duration' => $info->getOEmbed()->int('duration'),
        ]);
        $link->setTitle($info->title);
        $link->setAuthor($info->authorName);
        $link->setProvider($info->providerName);
        $link->setUrl($info->url);
        return $link;
    }
}