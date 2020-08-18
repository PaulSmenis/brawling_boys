<?php

namespace App\Entity;

use App\Repository\BodyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BodyRepository::class)
 */
class Body
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Bodypart::class, mappedBy="body", orphanRemoval=true, cascade={"persist"})
     */
    private $bodyparts;

    /**
     * @ORM\OneToOne(targetEntity=Inventory::class, inversedBy="body", cascade={"persist", "remove"})
     */
    private $inventory;

    /**
     * @ORM\OneToOne(targetEntity=Megaman::class, mappedBy="body", cascade={"persist", "remove"})
     */
    private $megaman;

    public function __construct()
    {
        $this->bodyparts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|bodyparts[]
     */
    public function getBodyparts(): Collection
    {
        return $this->bodyparts;
    }

    public function getBodypart(string $bodypart_name): ?Bodypart 
    {
        foreach ($this->bodyparts as $part) {
            if ($part->getName() === $bodypart_name)
                return $part;
        }
        return NULL;
    }

    public function addBodypart(bodypart $bodypart): self
    {
        if (!$this->bodyparts->contains($bodypart)) {
            $this->bodyparts[] = $bodypart;
            $bodypart->setBody($this);
        }

        return $this;
    }

    public function removeBodypart(bodypart $bodypart): self
    {
        if ($this->bodypart->contains($bodypart)) {
            $this->bodypart->removeElement($bodypart);
            // set the owning side to null (unless already changed)
            if ($bodypart->getBody() === $this) {
                $bodypart->setBody(null);
            }
        }
        return $this;
    }

    public function getInventory(): ?inventory
    {
        return $this->inventory;
    }

    public function setInventory(?inventory $inventory): self
    {
        $this->inventory = $inventory;

        return $this;
    }

    public function getMegaman(): ?Megaman
    {
        return $this->megaman;
    }

    public function setMegaman(Megaman $megaman): self
    {
        $this->megaman = $megaman;

        // set the owning side of the relation if necessary
        if ($megaman->getBody() !== $this) {
            $megaman->setBody($this);
        }

        return $this;
    }
}
