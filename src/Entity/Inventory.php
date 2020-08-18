<?php

namespace App\Entity;

use App\Entity\Medkit;
use App\Repository\InventoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventoryRepository::class)
 */
class Inventory
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
    private $volume;

    /**
     * @ORM\OneToOne(targetEntity=Body::class, mappedBy="inventory", cascade={"persist", "remove"})
     */
    private $body;

    /**
     * @ORM\Column(type="array")
     */
    private $items = [];

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBody(): ?Body
    {
        return $this->body;
    }

    public function setBody(?Body $body): self
    {
        $this->body = $body;

        // set (or unset) the owning side of the relation if necessary
        $newInventory = null === $body ? null : $this;
        if ($body->getInventory() !== $newInventory) {
            $body->setInventory($newInventory);
        }

        return $this;
    }

    public function putMedkit(Medkit $item): self 
    {
        $this->$items[] += $item;

        return $this;
    }

    public function getItems(): ?array
    {
        return $this->items;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }
}
