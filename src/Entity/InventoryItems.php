<?php

namespace App\Entity;

use App\Repository\InventoryItemsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventoryItemsRepository::class)
 */
class InventoryItems
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
    private $item_type;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Inventory::class, inversedBy="items")
     */
    private $inventory;

    /**
     * @ORM\Column(type="integer")
     */
    private $volume;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemType(): ?string
    {
        return $this->item_type;
    }

    public function setItemType(string $item_type): self
    {
        $this->item_type = $item_type;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getInventory(): ?Inventory
    {
        return $this->inventory;
    }

    public function setInventory(?Inventory $inventory): self
    {
        $this->inventory = $inventory;

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