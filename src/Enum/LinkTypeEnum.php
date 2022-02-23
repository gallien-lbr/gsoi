<?php

namespace App\Enum;


class LinkTypeEnum
{
    public const TYPE_VIDEO = 'video';
    public const TYPE_IMAGE = 'image';

    public const LINK_TYPES = [self::TYPE_VIDEO, self::TYPE_IMAGE];
}