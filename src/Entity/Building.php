<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BuildingRepository")
 */
class Building
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $function;

    /**
     * @ORM\ManyToMany(
     * targetEntity="App\Entity\agglomeration",
     * inversedBy="buildings",
     * cascade={"persist"}
     * )
     * @Assert\NotBlank())
     */
    private $agglomeration;

    /**
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $leader;

    public function __construct()
    {
        $this->agglomeration = new ArrayCollection();
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

    public function getFunction(): ?string
    {
        return $this->function;
    }

    public function setFunction(string $function): self
    {
        $this->function = $function;

        return $this;
    }

    /**
     * @return Collection|agglomeration[]
     */
    public function getAgglomeration(): Collection
    {
        return $this->agglomeration;
    }

    public function addAgglomeration(agglomeration $agglomeration): self
    {
        if (!$this->agglomeration->contains($agglomeration)) {
            $this->agglomeration[] = $agglomeration;
        }

        return $this;
    }

    public function removeAgglomeration(agglomeration $agglomeration): self
    {
        if ($this->agglomeration->contains($agglomeration)) {
            $this->agglomeration->removeElement($agglomeration);
        }

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getLeader(): ?string
    {
        return $this->leader;
    }

    public function setLeader(?string $leader): self
    {
        $this->leader = $leader;

        return $this;
    }
}
