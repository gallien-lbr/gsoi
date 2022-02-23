<?php


namespace App\Repository;

use App\Entity\Link;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LinkRepository extends ServiceEntityRepository implements LinkRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Link::class);
    }

    public function save(Link $link):bool
    {
        try {
            $this->_em->persist($link);
            $this->_em->flush();

            return true;
        } catch (Throwable $e) {
            return false;
        }
    }
}