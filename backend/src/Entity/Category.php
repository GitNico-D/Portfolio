<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="50")
     * @Groups({"category:read"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Skill::class, mappedBy="category", cascade={"ALL"})
     * @Groups({"category:read"})
     */
    private $skills;

    /**
     * @ORM\OneToMany(targetEntity=Software::class, mappedBy="category", cascade={"ALL"})
     * @Groups({"category:read"})
     */
    private $softwares;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->softwares = new ArrayCollection();
    }

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

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setCategory($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
            // set the owning side to null (unless already changed)
            if ($skill->getCategory() === $this) {
                $skill->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Software[]
     */
    public function getSoftwares(): Collection
    {
        return $this->softwares;
    }

    public function addSoftware(Software $software): self
    {
        if (!$this->softwares->contains($software)) {
            $this->softwares[] = $software;
            $software->setCategory($this);
        }

        return $this;
    }

    public function removeSoftware(Software $software): self
    {
        if ($this->softwares->contains($software)) {
            $this->softwares->removeElement($software);
            // set the owning side to null (unless already changed)
            if ($software->getCategory() === $this) {
                $software->setCategory(null);
            }
        }

        return $this;
    }
}
