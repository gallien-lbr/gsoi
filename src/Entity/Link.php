<?php


namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\ORM\Mapping as ORM;

class Link
{
    private string $url;
    private string $providerName;
    private string $title;
    private string $author;
    private $createdAt;
    private $publishedAt;
}