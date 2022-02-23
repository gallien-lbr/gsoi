<?php


namespace App\Repository;

use App\Entity\Link;

interface LinkRepositoryInterface
{
    public function save(Link $link):bool;
}