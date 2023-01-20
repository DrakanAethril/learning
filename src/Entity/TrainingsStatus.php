<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TrainingsStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingsStatusRepository::class)]
#[ApiResource]
class TrainingsStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: Trainings::class)]
    private Collection $trainings;

    public function __construct()
    {
        $this->trainings = new ArrayCollection();
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

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

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
            $training->setStatus($this);
        }

        return $this;
    }

    public function removeTraining(Trainings $training): self
    {
        if ($this->trainings->removeElement($training)) {
            // set the owning side to null (unless already changed)
            if ($training->getStatus() === $this) {
                $training->setStatus(null);
            }
        }

        return $this;
    }
}
