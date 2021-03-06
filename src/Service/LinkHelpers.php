<?php

declare(strict_types=1);
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
        return (!filter_var($url, FILTER_VALIDATE_URL) === false);
    }

    /**
     * todo: Add published date (seems to be missing in OEmbed metadatas)
     * @param $info
     * @return Link
     */
    public static function extractLinkEntity($info): Link
    {
        $link = new Link();
        $link->setTitle($info->title)
            ->setAuthor($info->authorName)
            ->setProvider($info->providerName)
            ->setUrl($info->url)
            ->setType(self::extractTypeFromProvider($info->providerName))
        ;

        foreach (self::getPropertiesList($link) as $propertyName){
            if(\property_exists($info->code,$propertyName)){
                $link->addProperty($propertyName, $info->getOEmbed()->int($propertyName));
            }
        }
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
            case ProviderEnum::PROVIDER_FLICKR:
                $type = LinkTypeEnum::TYPE_IMAGE;
                break;
        }

        return $type;
    }

    public static function getPropertiesList(Link $link):array
    {
        $type = $link->getType();
        $properties = [LinkPropertyEnum::PROPERTY_WIDTH, LinkPropertyEnum::PROPERTY_HEIGHT];
        switch ($type){
            case LinkTypeEnum::TYPE_VIDEO:
                $properties[] = LinkPropertyEnum::PROPERTY_DURATION;
                break;

            case LinkTypeEnum::TYPE_IMAGE:
                break;
        }
        return $properties;
    }
}