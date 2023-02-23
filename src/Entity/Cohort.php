<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CohortRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CohortRepository::class)]
#[ApiResource]
class Cohort
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne(inversedBy: 'cohorts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?structure $structure = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'cohorts')]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: Trainings::class, mappedBy: 'cohorts')]
    private Collection $trainings;

    #[ORM\ManyToMany(targetEntity: RegisterKey::class, mappedBy: 'cohorts')]
    private Collection $registerKeys;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->trainings = new ArrayCollection();
        $this->registerKeys = new ArrayCollection();
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

    public function getStructure(): ?structure
    {
        return $this->structure;
    }

    public function setStructure(?structure $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    public function __toString(): string
    {
        $structure = empty($this->getStructure()) ? '' : ' ('.$this->getStructure().')';
        return $this->getName().$structure;
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
            $training->addCohort($this);
        }

        return $this;
    }

    public function removeTraining(Trainings $training): self
    {
        if ($this->trainings->removeElement($training)) {
            $training->removeCohort($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, RegisterKey>
     */
    public function getRegisterKeys(): Collection
    {
        return $this->registerKeys;
    }

    public function addRegisterKey(RegisterKey $registerKey): self
    {
        if (!$this->registerKeys->contains($registerKey)) {
            $this->registerKeys->add($registerKey);
            $registerKey->addCohort($this);
        }

        return $this;
    }

    public function removeRegisterKey(RegisterKey $registerKey): self
    {
        if ($this->registerKeys->removeElement($registerKey)) {
            $registerKey->removeCohort($this);
        }

        return $this;
    }


}
