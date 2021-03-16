<?php

namespace App\Entity;

use App\Repository\PresentationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PresentationRepository::class)
 */
class Presentation
{
    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"presentation:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="25")
     * @Groups({"presentation:read"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="25")
     * @Groups({"presentation:read"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="255")
     * @Groups({"presentation:read"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="255")
     * @Groups({"presentation:read"})
     */
    private $quote;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="100")
     * @Groups({"presentation:read"})
     */
    private $titleFirstText;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(min="5")
     * @Groups({"presentation:read"})
     */
    private $firstText;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="100")
     * @Groups({"presentation:read"})
     */
    private $titleSecondText;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(min="5")
     * @Groups({"presentation:read"})
     */
    private $secondText;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="100")
     * @Groups({"presentation:read"})
     */
    private $titleThirdText;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(min="5")
     * @Groups({"presentation:read"})
     */
    private $thirdText;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="presentation", cascade={"ALL"})
     * @Groups({"presentation:read"})
     */
    private $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getQuote(): ?string
    {
        return $this->quote;
    }

    public function setQuote(string $quote): self
    {
        $this->quote = $quote;

        return $this;
    }

    public function getTitleFirstText(): ?string
    {
        return $this->titleFirstText;
    }

    public function setTitleFirstText(string $titleFirstText): self
    {
        $this->titleFirstText = $titleFirstText;

        return $this;
    }

    public function getFirstText(): ?string
    {
        return $this->firstText;
    }

    public function setFirstText(string $firstText): self
    {
        $this->firstText = $firstText;

        return $this;
    }

    public function getTitleSecondText(): ?string
    {
        return $this->titleSecondText;
    }

    public function setTitleSecondText(string $titleSecondText): self
    {
        $this->titleSecondText = $titleSecondText;

        return $this;
    }

    public function getSecondText(): ?string
    {
        return $this->secondText;
    }

    public function setSecondText(string $secondText): self
    {
        $this->secondText = $secondText;

        return $this;
    }

    public function getTitleThirdText(): ?string
    {
        return $this->titleThirdText;
    }

    public function setTitleThirdText(string $titleThirdText): self
    {
        $this->titleThirdText = $titleThirdText;

        return $this;
    }

    public function getThirdText(): ?string
    {
        return $this->thirdText;
    }

    public function setThirdText(string $thirdText): self
    {
        $this->thirdText = $thirdText;

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setPresentation($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getPresentation() === $this) {
                $contact->setPresentation(null);
            }
        }

        return $this;
    }
}
