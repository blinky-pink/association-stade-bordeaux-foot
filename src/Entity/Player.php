<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $FirstName = null;

    #[ORM\Column(length: 255)]
    private ?string $LastName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $BirthDate = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Phone = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Position = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Photo = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $JerseySize = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $ShortsSize = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $MedicalInfo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CoachNote = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team = null;

    /**
     * @var Collection<int, Responsable>
     */
    #[ORM\OneToMany(targetEntity: Responsable::class, mappedBy: 'player')]
    private Collection $responsables;

    /**
     * @var Collection<int, Presence>
     */
    #[ORM\OneToMany(targetEntity: Presence::class, mappedBy: 'player')]
    private Collection $presences;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'player')]
    private Collection $messages;

    public function __construct()
    {
        $this->responsables = new ArrayCollection();
        $this->presences = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): static
    {
        $this->FirstName = $FirstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): static
    {
        $this->LastName = $LastName;
        return $this;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->BirthDate;
    }

    public function setBirthDate(\DateTime $BirthDate): static
    {
        $this->BirthDate = $BirthDate;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->Phone;
    }

    public function setPhone(?string $Phone): static
    {
        $this->Phone = $Phone;
        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->Position;
    }

    public function setPosition(?string $Position): static
    {
        $this->Position = $Position;
        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(?string $Photo): static
    {
        $this->Photo = $Photo;
        return $this;
    }

    public function getJerseySize(): ?string
    {
        return $this->JerseySize;
    }

    public function setJerseySize(?string $JerseySize): static
    {
        $this->JerseySize = $JerseySize;
        return $this;
    }

    public function getShortsSize(): ?string
    {
        return $this->ShortsSize;
    }

    public function setShortsSize(?string $ShortsSize): static
    {
        $this->ShortsSize = $ShortsSize;
        return $this;
    }

    public function getMedicalInfo(): ?string
    {
        return $this->MedicalInfo;
    }

    public function setMedicalInfo(?string $MedicalInfo): static
    {
        $this->MedicalInfo = $MedicalInfo;
        return $this;
    }

    public function getCoachNote(): ?string
    {
        return $this->CoachNote;
    }

    public function setCoachNote(?string $CoachNote): static
    {
        $this->CoachNote = $CoachNote;
        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;
        return $this;
    }

    /**
     * @return Collection<int, Responsable>
     */
    public function getResponsables(): Collection
    {
        return $this->responsables;
    }

    public function addResponsable(Responsable $responsable): static
    {
        if (!$this->responsables->contains($responsable)) {
            $this->responsables->add($responsable);
            $responsable->setPlayer($this);
        }
        return $this;
    }

    public function removeResponsable(Responsable $responsable): static
    {
        if ($this->responsables->removeElement($responsable)) {
            if ($responsable->getPlayer() === $this) {
                $responsable->setPlayer(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Presence>
     */
    public function getPresences(): Collection
    {
        return $this->presences;
    }

    public function addPresence(Presence $presence): static
    {
        if (!$this->presences->contains($presence)) {
            $this->presences->add($presence);
            $presence->setPlayer($this);
        }
        return $this;
    }

    public function removePresence(Presence $presence): static
    {
        if ($this->presences->removeElement($presence)) {
            if ($presence->getPlayer() === $this) {
                $presence->setPlayer(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setPlayer($this);
        }
        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            if ($message->getPlayer() === $this) {
                $message->setPlayer(null);
            }
        }
        return $this;
    }
}