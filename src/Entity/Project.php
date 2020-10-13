<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img_static;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img_hover;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $alt_static;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $alt_hover;

    /**
     * @ORM\Column(type="datetime")
     */
    private $create_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getImgStatic(): ?string
    {
        return $this->img_static;
    }

    public function setImgStatic(string $img_static): self
    {
        $this->img_static = $img_static;

        return $this;
    }

    public function getImgHover(): ?string
    {
        return $this->img_hover;
    }

    public function setImgHover(string $img_hover): self
    {
        $this->img_hover = $img_hover;

        return $this;
    }

    public function getAltStatic(): ?string
    {
        return $this->alt_static;
    }

    public function setAltStatic(string $alt_static): self
    {
        $this->alt_static = $alt_static;

        return $this;
    }

    public function getAltHover(): ?string
    {
        return $this->alt_hover;
    }

    public function setAltHover(string $alt_hover): self
    {
        $this->alt_hover = $alt_hover;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }
}
