<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MapRepository")
 */
class Map
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
     * @ORM\ManyToOne(
     * targetEntity="App\Entity\user",
     * inversedBy="maps",
     * cascade={"persist"}
     * )
     * @Assert\NotBlank()
     */
    private $user;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $biomes = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $universe_type;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $interest_points = [];

    /**
     * @ORM\ManyToMany(
     * targetEntity="App\Entity\Agglomeration",
     * mappedBy="map",
     * cascade={"persist"}
     * )
     * @Assert\Valid()
     */
    private $agglomerations;

    public function __construct()
    {
        $this->agglomerations = new ArrayCollection();
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

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBiomes(): ?array
    {
        return $this->biomes;
    }

    public function setBiomes(array $biomes): self
    {
        $this->biomes = $biomes;

        return $this;
    }

    public function getUniverseType(): ?int
    {
        return $this->universe_type;
    }

    public function setUniverseType(?int $universe_type): self
    {
        $this->universe_type = $universe_type;

        return $this;
    }

    public function getInterestPoints(): ?array
    {
        return $this->interest_points;
    }

    public function setInterestPoints(?array $interest_points): self
    {
        $this->interest_points = $interest_points;

        return $this;
    }

    /**
     * @return Collection|Agglomeration[]
     */
    public function getAgglomerations(): Collection
    {
        return $this->agglomerations;
    }

    public function addAgglomeration(Agglomeration $agglomeration): self
    {
        if (!$this->agglomerations->contains($agglomeration)) {
            $this->agglomerations[] = $agglomeration;
            $agglomeration->addMap($this);
        }

        return $this;
    }

    public function removeAgglomeration(Agglomeration $agglomeration): self
    {
        if ($this->agglomerations->contains($agglomeration)) {
            $this->agglomerations->removeElement($agglomeration);
            $agglomeration->removeMap($this);
        }

        return $this;
    }
}
