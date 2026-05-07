<?php

namespace App\Entity;

use App\Repository\ResponsableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponsableRepository::class)]
class Responsable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Email = null;

    #[ORM\Column(length: 20)]
    private ?string $Phone = null;

    #[ORM\ManyToOne(inversedBy: 'responsables')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $player = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;  // ✅ majuscule
    }

    public function setEmail(?string $Email): static
    {
        $this->Email = $Email;  // ✅ majuscule
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->Phone;
    }

    public function setPhone(string $Phone): static
    {
        $this->Phone = $Phone;
        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): static
    {
        $this->player = $player;
        return $this;
    }
}