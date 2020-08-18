<?php

namespace App\Entity;

use App\Repository\MedkitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedkitRepository::class)
 */
class Medkit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $healing_capacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $volume;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHealingCapacity(): ?int
    {
        return $this->healing_capacity;
    }

    public function setHealingCapacity(int $healing_capacity): self
    {
        $this->healing_capacity = $healing_capacity;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(int $volume): self
    {
        $this->volume = $volume;

        return $this;
    }
}
