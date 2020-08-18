<?php

namespace App\Entity;

use App\Entity\Medkit;
use App\Repository\InventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=InventoryItems::class, mappedBy="inventory", cascade={"persist"})
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

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

    /**
     * @return Collection|InventoryItems[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getItem(string $item_type): InventoryItems 
    {
        return $this->getItems()[$item_type];
    }

    public function addItem(InventoryItems $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setInventory($this);
        } else {
            $this->getItem($item->getItemType())->setQuantity($item->getQuantity() + 1);
        }

        return $this;
    }

    public function removeItem(InventoryItems $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getInventory() === $this) {
                $item->setInventory(null);
            }
        }

        return $this;
    }
}
