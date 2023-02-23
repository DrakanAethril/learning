<?php

namespace App\Entity;

use App\Repository\RegisterKeyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegisterKeyRepository::class)]
class RegisterKey
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $key_code = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\ManyToMany(targetEntity: Structure::class, inversedBy: 'registerKeys')]
    private Collection $structures;

    #[ORM\ManyToMany(targetEntity: Cohort::class, inversedBy: 'registerKeys')]
    private Collection $cohorts;

    public function __construct()
    {
        $this->structures = new ArrayCollection();
        $this->cohorts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeyCode(): ?string
    {
        return $this->key_code;
    }

    public function setKeyCode(string $key_code): self
    {
        $this->key_code = $key_code;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Structure>
     */
    public function getStructures(): Collection
    {
        return $this->structures;
    }

    public function addStructure(Structure $structure): self
    {
        if (!$this->structures->contains($structure)) {
            $this->structures->add($structure);
        }

        return $this;
    }

    public function removeStructure(Structure $structure): self
    {
        $this->structures->removeElement($structure);

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
}
