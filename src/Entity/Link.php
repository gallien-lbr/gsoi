<?php


namespace App\Entity;

use App\Enum\LinkTypeEnum;
use App\Enum\ProviderEnum;
use App\Repository\LinkRepository;
use App\Service\LinkHelpers;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Internal\TentativeType;

/**
 * @ORM\Entity(repositoryClass=LinkRepository::class)
 * @ORM\Table(name="link")
 * @ORM\HasLifecycleCallbacks
 */
class Link implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\Column(type="string", name="url", length=2048, nullable=true)
     */
    private ?string $url;

    /**
     * @ORM\Column(type="string", name="provider", length=255, nullable=true)
     */
    private ?string $provider;

    /**
     * @ORM\Column(type="string", name="title", length=255, nullable=true)
     */
    private ?string $title;

    /**
     * @ORM\Column(type="string", name="author", length=255, nullable=true)
     */
    private ?string $author;

    /* @ORM\Column(type="datetime", name="created_at") */
    private \DateTime $createdAt;

    /* @ORM\Column(type="datetime", name="published_at") */
    private \DateTime $publishedAt;

    /**
     * @ORM\Column(type="string", name="type", length=255, nullable=true)
     */
    private ?string $type;

    /**
     * @ORM\Column(type="json")
     */
    private array $properties;

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     */
    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        if (!in_array($type, LinkTypeEnum::LINK_TYPES)) {
            throw new \InvalidArgumentException("Invalid link type");
        }
        $this->type = $type;
    }


    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getProvider(): ?string
    {
        return $this->provider;
    }

    /**
     * @param string|null $provider
     */
    public function setProvider(?string $provider): void
    {
        $provider = LinkHelpers::extractProvider($provider);
        if (!$provider) {
            throw new \InvalidArgumentException("Invalid provider");
        }
        $this->provider = $provider;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string|null $author
     */
    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getPublishedAt(): \DateTime
    {
        return $this->publishedAt;
    }

    /**
     * @param \DateTime $publishedAt
     */
    public function setPublishedAt(\DateTime $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function jsonSerialize()
    {
        return ['id' => $this->getId(),
            'url' => $this->getUrl(),
            'author' => $this->getAuthor(),
            'provider' => $this->getProvider(),
            'properties' => $this->getProperties(),
            'created_at' => $this->getCreatedAt(),
            'title' => $this->getTitle(),
        ];
    }
}