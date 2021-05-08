<?php

namespace App\Entity;

use App\Repository\ProjetFinEtudeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjetFinEtudeRepository::class)
 */
class ProjetFinEtude
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projetFinEtudes")
     */
    private $enseignant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAffected;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isConfirmedAdmin;

    /**
     * @ORM\OneToMany(targetEntity=Postule::class, mappedBy="pfe")
     */
    private $postules;

    public function __construct()
    {
        $this->postules = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnseignant(): ?User
    {
        return $this->enseignant;
    }

    public function setEnseignant(?User $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getIsAffected(): ?bool
    {
        return $this->isAffected;
    }

    public function setIsAffected(bool $isAffected): self
    {
        $this->isAffected = $isAffected;

        return $this;
    }

    public function getIsConfirmedAdmin(): ?bool
    {
        return $this->isConfirmedAdmin;
    }

    public function setIsConfirmedAdmin(bool $isConfirmedAdmin): self
    {
        $this->isConfirmedAdmin = $isConfirmedAdmin;

        return $this;
    }

   

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @return Collection|Postule[]
     */
    public function getPostules(): Collection
    {
        return $this->postules;
    }

    public function addPostule(Postule $postule): self
    {
        if (!$this->postules->contains($postule)) {
            $this->postules[] = $postule;
            $postule->setPfe($this);
        }

        return $this;
    }

    public function removePostule(Postule $postule): self
    {
        if ($this->postules->removeElement($postule)) {
            // set the owning side to null (unless already changed)
            if ($postule->getPfe() === $this) {
                $postule->setPfe(null);
            }
        }

        return $this;
    }
}
