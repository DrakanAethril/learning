<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TrainingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingsRepository::class)]
#[ApiResource]
class Trainings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?bool $force_requirements = null;

    #[ORM\Column]
    private array $params = [];

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $creation_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\ManyToOne(inversedBy: 'trainings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\ManyToMany(targetEntity: Cohort::class, inversedBy: 'trainings')]
    private Collection $cohorts;

    #[ORM\ManyToMany(targetEntity: Resource::class, inversedBy: 'required_for_trainings')]
    private Collection $requirements;

    #[ORM\ManyToOne(inversedBy: 'trainings')]
    private ?Resource $resource = null;

    #[ORM\ManyToOne(inversedBy: 'trainings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TrainingsStatus $status = null;

    public function __construct()
    {
        $this->cohorts = new ArrayCollection();
        $this->requirements = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isForceRequirements(): ?bool
    {
        return $this->force_requirements;
    }

    public function setForceRequirements(?bool $force_requirements): self
    {
        $this->force_requirements = $force_requirements;

        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

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

    /**
     * @return Collection<int, Cohort>
     */
    public function getCohorts(): Collection
    {
        return $this->cohorts;
    }

    public function addCohort(Cohort $cohort): self
    {
        if (!$this->cohorts->contains($cohort)) {
            $this->cohorts->add($cohort);
        }

        return $this;
    }

    public function removeCohort(Cohort $cohort): self
    {
        $this->cohorts->removeElement($cohort);

        return $this;
    }

    /**
     * @return Collection<int, Resource>
     */
    public function getRequirements(): Collection
    {
        return $this->requirements;
    }

    public function addRequirement(Resource $requirement): self
    {
        if (!$this->requirements->contains($requirement)) {
            $this->requirements->add($requirement);
        }

        return $this;
    }

    public function removeRequirement(Resource $requirement): self
    {
        $this->requirements->removeElement($requirement);

        return $this;
    }

    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    public function setResource(?Resource $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    public function getStatus(): ?TrainingsStatus
    {
        return $this->status;
    }

    public function setStatus(?TrainingsStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

}
