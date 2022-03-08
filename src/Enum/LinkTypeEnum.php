<?php
declare(strict_types=1);
namespace App\Enum;


class LinkTypeEnum
{
    public const TYPE_VIDEO = 'video';
    public const TYPE_IMAGE = 'image';
    public const TYPE_UNDEFINED = 'undefined';

    public const LINK_TYPES = [self::TYPE_VIDEO, self::TYPE_IMAGE, self::TYPE_UNDEFINED];
}