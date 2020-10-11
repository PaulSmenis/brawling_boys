<?php

namespace App\Entity;

use App\Repository\BodypartRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BodypartRepository::class)
 */
class Bodypart
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
    private $health;

    /**
     * @ORM\ManyToOne(targetEntity=Body::class, inversedBy="bodyparts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $body;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public const BODYPARTS_LIST = [
        'left leg', 'left hand', 'left arm', 'left foot', 'left knee', 'left elbow', 'left hand', 'left ear', 'left eye', 
        'right leg', 'right hand', 'right arm', 'right foot', 'right knee', 'right elbow', 'right hand', 'right ear', 'right eye',
        'head', 'torso', 'neck', 'pee-pee'
    ];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHealth(): ?int
    {
        return $this->health;
    }

    public function setHealth(int $health): self
    {
        $this->health = $health;

        return $this;
    }

    public function getBody(): ?Body
    {
        return $this->body;
    }

    public function setBody(?Body $body): self
    {
        $this->body = $body;

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
    
    // Для административной панели
    public function __toString() 
    {
        return $this->getName();
    }
}
