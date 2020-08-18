<?php

namespace App\Entity;

use App\Repository\MegamanRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MegamanRepository::class)
 */
class Megaman
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $birth_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Body::class, inversedBy="megaman", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $body;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTimeInterface $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
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

    public function getBody(): ?body
    {
        return $this->body;
    }

    public function setBody(body $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getAverageHealth(): int {
        $bodyparts = $this->getBody()->getBodyparts();
        $sum = $n = 0;
        foreach ($bodyparts as $part) {
            $sum += $part->getHealth();
            $n++;
        }
        return (int) ($sum / $n);
    }
}
