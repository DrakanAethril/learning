<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ResourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResourceRepository::class)]
#[ApiResource]
class Resource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'resources')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ResourceType $type = null;

    #[ORM\ManyToOne(inversedBy: 'resources')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $date_create = null;

    #[ORM\ManyToOne(inversedBy: 'resources')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ResourceStatus $status = null;

    #[ORM\Column(nullable: true)]
    private array $content = [];

    #[ORM\ManyToMany(targetEntity: Trainings::class, mappedBy: 'requirements')]
    private Collection $required_for_trainings;

    #[ORM\OneToMany(mappedBy: 'resource', targetEntity: Trainings::class)]
    private Collection $trainings;

    public function __construct()
    {
        $this->trainings = new ArrayCollection();
        $this->required_for_trainings = new ArrayCollection();
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

    public function getType(): ?ResourceType
    {
        return $this->type;
    }

    public function setType(?ResourceType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeInterface $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getStatus(): ?ResourceStatus
    {
        return $this->status;
    }

    public function setStatus(?ResourceStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function setContent(?array $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, Trainings>
     */
    public function getRequiredForTrainings(): Collection
    {
        return $this->required_for_trainings;
    }

    public function addRequiredForTraining(Trainings $requiredForTraining): self
    {
        if (!$this->required_for_trainings->contains($requiredForTraining)) {
            $this->required_for_trainings->add($requiredForTraining);
            $requiredForTraining->addRequirement($this);
        }

        return $this;
    }

    public function removeRequiredForTraining(Trainings $requiredForTraining): self
    {
        if ($this->required_for_trainings->removeElement($requiredForTraining)) {
            $requiredForTraining->removeRequirement($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Trainings>
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Trainings $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings->add($training);
            $training->setResource($this);
        }

        return $this;
    }

    public function removeTraining(Trainings $training): self
    {
        if ($this->trainings->removeElement($training)) {
            // set the owning side to null (unless already changed)
            if ($training->getResource() === $this) {
                $training->setResource(null);
            }
        }

        return $this;
    }

}
