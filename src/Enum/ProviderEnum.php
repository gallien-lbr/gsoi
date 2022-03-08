<?php
declare(strict_types=1);
namespace App\Enum;


class ProviderEnum
{
    public const PROVIDER_YOUTUBE = 'youtube.com';
    public const PROVIDER_VIMEO = 'vimeo.com';
    public const PROVIDER_FLICKR = 'flickr.com';

    public const PROVIDERS = [self::PROVIDER_YOUTUBE, self::PROVIDER_VIMEO, self::PROVIDER_FLICKR];
}