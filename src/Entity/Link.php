<?php


namespace App\Entity;

use App\Enum\LinkTypeEnum;
use App\Enum\ProviderEnum;
use App\Repository\LinkRepository;
use App\Service\LinkHelpers;
use Doctrine\ORM\Mapping as ORM;

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

    /**
     * @ORM\Column(type="datetime", name="created")
     */
    private \DateTime $created;

    /**
     * @ORM\Column(type="datetime", name="published", nullable=true)
     */
    private  \DateTime  $published;

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
    public function setProperties(array $properties): self
    {
        $this->properties = $properties;
        return $this;
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
        $type = LinkHelpers::extractTypeFromProvider($this->getProvider());
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
    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
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
    public function setProvider(?string $provider): self
    {
        $provider = LinkHelpers::extractProvider($provider);
        if (!$provider) {
            throw new \InvalidArgumentException("Invalid provider");
        }
        $this->provider = $provider;
        return $this;
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
    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
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
    public function setAuthor(?string $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
       return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getPublished(): \DateTime
    {
        return $this->published;
    }

    /**
     * @param \DateTime $publishedAt
     */
    public function setPublished(\DateTime $published): self
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'url' => $this->getUrl(),
            'author' => $this->getAuthor(),
            'provider' => $this->getProvider(),
            'properties' => $this->getProperties(),
            'created' => $this->getCreated(),
            'published' => $this->getPublished(),
            'title' => $this->getTitle(),
            'type' => $this->getType(),
        ];
    }
}