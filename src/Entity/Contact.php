<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContactRepository;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;


#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]

    #[Length(min: 2, max: 100)]
    private ?string $Nom = null;

    #[ORM\Column(length: 100)]
    private ?string $Prenom = null;

    #[ORM\Column(type:'string',length: 255)]

    #[Length(min: 2, max: 180)]
    private ?string $Email = null;

    #[Length(min: 2, max: 100)]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $Sujet = null;

    #[ORM\Column(type: Types::TEXT)]

    #[NotBlank()]
    private ?string $Message = null;

    #[ORM\Column]

    #[NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->Sujet;
    }

    public function setSujet(string $Sujet): self
    {
        $this->Sujet = $Sujet;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(string $Message): self
    {
        $this->Message = $Message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}
