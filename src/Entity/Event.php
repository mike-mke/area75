<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Table(name: 'event')]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Please enter an event title.')]
    #[Assert\Length(max: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message: 'Please provide a start date and time.')]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $state = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $zip = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $flyerPath = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $zoomLink = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $createdBy = null;

    #[ORM\Column]
    private bool $isApproved = false;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): static { $this->title = $title; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $d): static { $this->description = $d; return $this; }

    public function getStartDate(): ?\DateTimeInterface { return $this->startDate; }
    public function setStartDate(\DateTimeInterface $d): static { $this->startDate = $d; return $this; }

    public function getEndDate(): ?\DateTimeInterface { return $this->endDate; }
    public function setEndDate(?\DateTimeInterface $d): static { $this->endDate = $d; return $this; }

    public function getLocation(): ?string { return $this->location; }
    public function setLocation(?string $l): static { $this->location = $l; return $this; }

    public function getAddress(): ?string { return $this->address; }
    public function setAddress(?string $a): static { $this->address = $a; return $this; }

    public function getCity(): ?string { return $this->city; }
    public function setCity(?string $c): static { $this->city = $c; return $this; }

    public function getState(): ?string { return $this->state; }
    public function setState(?string $s): static { $this->state = $s; return $this; }

    public function getZip(): ?string { return $this->zip; }
    public function setZip(?string $z): static { $this->zip = $z; return $this; }

    public function getFlyerPath(): ?string { return $this->flyerPath; }
    public function setFlyerPath(?string $p): static { $this->flyerPath = $p; return $this; }

    public function getZoomLink(): ?string { return $this->zoomLink; }
    public function setZoomLink(?string $z): static { $this->zoomLink = $z; return $this; }

    public function getCreatedBy(): ?User { return $this->createdBy; }
    public function setCreatedBy(?User $u): static { $this->createdBy = $u; return $this; }

    public function isApproved(): bool { return $this->isApproved; }
    public function setIsApproved(bool $a): static { $this->isApproved = $a; return $this; }

    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }

    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }
    public function setUpdatedAt(?\DateTimeImmutable $d): static { $this->updatedAt = $d; return $this; }

    public function getFullAddress(): string
    {
        $parts = array_filter([$this->address, $this->city, $this->state, $this->zip]);
        return implode(', ', $parts);
    }
}
