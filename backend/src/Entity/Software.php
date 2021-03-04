<?php

namespace App\Entity;

use App\Repository\SoftwareRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SoftwareRepository::class)
 */
class Software
{
    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"category:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=75)
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="75")
     * @Groups({"category:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="100")
     * @Groups({"category:read"})
     */
    private $icon;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive
     * @Assert\Type("integer")
     * @Groups({"category:read"})
     */
    private $mastery_of;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="softwares", cascade={"persist"})
     */
    private $category;

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getMasteryOf(): ?int
    {
        return $this->mastery_of;
    }

    public function setMasteryOf(int $mastery_of): self
    {
        $this->mastery_of = $mastery_of;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
