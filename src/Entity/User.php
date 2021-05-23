<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel;

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $grade;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="users")
     */
    private $classe;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="users")
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emailAddress;

    /**
     * @ORM\OneToMany(targetEntity=ProjetFinEtude::class, mappedBy="enseignant",cascade={"persist"})
     */
    private $projetFinEtudes;

    /**
     * @ORM\OneToMany(targetEntity=Postule::class, mappedBy="student")
     */
    private $postules;

    /**
     * @ORM\OneToMany(targetEntity=ProjetFinEtude::class, mappedBy="reporter")
     */
    private $reporters;

    /**
     * @ORM\OneToMany(targetEntity=ProjetFinEtude::class, mappedBy="president")
     */
    private $presidentes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isChef;



    public function __construct()
    {
        $this->projetFinEtudes = new ArrayCollection();
        $this->postules = new ArrayCollection();
        $this->reporters = new ArrayCollection();
        $this->presidentes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->cin;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(?string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
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

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * @return Collection|ProjetFinEtude[]
     */
    public function getProjetFinEtudes(): Collection
    {
        return $this->projetFinEtudes;
    }

    public function addProjetFinEtude(ProjetFinEtude $projetFinEtude): self
    {
        if (!$this->projetFinEtudes->contains($projetFinEtude)) {
            $this->projetFinEtudes[] = $projetFinEtude;
            $projetFinEtude->setEnseignant($this);
        }

        return $this;
    }

    public function removeProjetFinEtude(ProjetFinEtude $projetFinEtude): self
    {
        if ($this->projetFinEtudes->removeElement($projetFinEtude)) {
            // set the owning side to null (unless already changed)
            if ($projetFinEtude->getEnseignant() === $this) {
                $projetFinEtude->setEnseignant(null);
            }
        }

        return $this;
    }

    public function getFullname(){
        return $this->firstName.' '.$this->lastName;
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
            $postule->setStudent($this);
        }

        return $this;
    }

    public function removePostule(Postule $postule): self
    {
        if ($this->postules->removeElement($postule)) {
            // set the owning side to null (unless already changed)
            if ($postule->getStudent() === $this) {
                $postule->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProjetFinEtude[]
     */
    public function getReporters(): Collection
    {
        return $this->reporters;
    }

    public function addReporter(ProjetFinEtude $reporter): self
    {
        if (!$this->reporters->contains($reporter)) {
            $this->reporters[] = $reporter;
            $reporter->setReporter($this);
        }

        return $this;
    }

    public function removeReporter(ProjetFinEtude $reporter): self
    {
        if ($this->reporters->removeElement($reporter)) {
            // set the owning side to null (unless already changed)
            if ($reporter->getReporter() === $this) {
                $reporter->setReporter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProjetFinEtude[]
     */
    public function getPresidentes(): Collection
    {
        return $this->presidentes;
    }

    public function addPresidente(ProjetFinEtude $presidente): self
    {
        if (!$this->presidentes->contains($presidente)) {
            $this->presidentes[] = $presidente;
            $presidente->setPresident($this);
        }

        return $this;
    }

    public function removePresidente(ProjetFinEtude $presidente): self
    {
        if ($this->presidentes->removeElement($presidente)) {
            // set the owning side to null (unless already changed)
            if ($presidente->getPresident() === $this) {
                $presidente->setPresident(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->firstName.' '.$this->lastName;
    }

    public function getIsChef(): ?bool
    {
        return $this->isChef;
    }

    public function setIsChef(bool $isChef): self
    {
        $this->isChef = $isChef;

        return $this;
    }
    
    
    
}
