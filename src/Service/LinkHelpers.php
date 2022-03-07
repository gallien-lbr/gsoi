<?php


namespace App\Service;


use App\Entity\Link;
use App\Enum\LinkPropertyEnum;
use App\Enum\LinkTypeEnum;
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
                LinkPropertyEnum::PROPERTY_WIDTH => $info->code->width,
                LinkPropertyEnum::PROPERTY_HEIGHT => $info->code->height,
                LinkPropertyEnum::PROPERTY_DURATION => $info->getOEmbed()->int(LinkPropertyEnum::PROPERTY_DURATION),
            ])->setTitle($info->title)
            ->setAuthor($info->authorName)
            ->setProvider($info->providerName)
            ->setUrl($info->url)
            ->setType(self::extractTypeFromProvider($info->providerName))
        ;

        return $link;
    }

    public static function extractTypeFromProvider(string $provider): ?string
    {
        $type = LinkTypeEnum::TYPE_UNDEFINED;
        switch ($provider) {
            case ProviderEnum::PROVIDER_YOUTUBE:
            case ProviderEnum::PROVIDER_VIMEO:
                $type = LinkTypeEnum::TYPE_VIDEO;
                break;
        }

        return $type;
    }
}