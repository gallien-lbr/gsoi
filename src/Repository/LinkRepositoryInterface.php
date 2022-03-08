<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Link;

interface LinkRepositoryInterface
{
    public function save(Link $link):bool;
}