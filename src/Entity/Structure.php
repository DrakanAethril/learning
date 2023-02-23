<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
#[ApiResource]
class Structure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'structure', targetEntity: Cohort::class)]
    private Collection $cohorts;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'structures')]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: RegisterKey::class, mappedBy: 'structures')]
    private Collection $registerKeys;

    public function __construct()
    {
        $this->cohorts = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function __toString(): string
    {
        return $this->getName();
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
            $cohort->setStructure($this);
        }

        return $this;
    }

    public function removeCohort(Cohort $cohort): self
    {
        if ($this->cohorts->removeElement($cohort)) {
            // set the owning side to null (unless already changed)
            if ($cohort->getStructure() === $this) {
                $cohort->setStructure(null);
            }
        }

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
            $registerKey->addStructure($this);
        }

        return $this;
    }

    public function removeRegisterKey(RegisterKey $registerKey): self
    {
        if ($this->registerKeys->removeElement($registerKey)) {
            $registerKey->removeStructure($this);
        }

        return $this;
    }

}
