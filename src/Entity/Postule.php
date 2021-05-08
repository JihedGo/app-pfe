<?php

namespace App\Entity;

use App\Repository\PostuleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostuleRepository::class)
 */
class Postule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ProjetFinEtude::class, inversedBy="postules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pfe;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="postules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\Column(type="datetime")
     */
    private $postuledAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAccepted;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reason;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPfe(): ?ProjetFinEtude
    {
        return $this->pfe;
    }

    public function setPfe(?ProjetFinEtude $pfe): self
    {
        $this->pfe = $pfe;

        return $this;
    }

    public function getStudent(): ?User
    {
        return $this->student;
    }

    public function setStudent(?User $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getPostuledAt(): ?\DateTimeInterface
    {
        return $this->postuledAt;
    }

    public function setPostuledAt(\DateTimeInterface $postuledAt): self
    {
        $this->postuledAt = $postuledAt;

        return $this;
    }

    public function getIsAccepted(): ?bool
    {
        return $this->isAccepted;
    }

    public function setIsAccepted(bool $isAccepted): self
    {
        $this->isAccepted = $isAccepted;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    
}
