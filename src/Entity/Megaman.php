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

    /**
     * @ORM\Column(type="integer")
     */
    private $STR;

    /**
     * @ORM\Column(type="integer")
     */
    private $INTELLECT;

    /**
     * @ORM\Column(type="integer")
     */
    private $PER;

    /**
     * @ORM\Column(type="integer")
     */
    private $CHA;

    /**
     * @ORM\Column(type="integer")
     */
    private $AGI;

    /**
     * @ORM\Column(type="integer")
     */
    private $LUC;

    /**
     * @ORM\Column(type="integer")
     */
    private $END;

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

    public function getAverageHealth(): int 
    {
        $bodyparts = $this->getBody()->getBodyparts();
        $sum = 0;
        $n = 0;
        foreach ($bodyparts as $part) {
            $sum += $part->getHealth();
            $n++;
        }
        return (int) ($sum / $n);
    }

    public function getSTR(): ?int
    {
        return $this->STR;
    }

    public function setSTR(int $STR): self
    {
        $this->STR = $STR;

        return $this;
    }

    public function getINTELLECT(): ?int
    {
        return $this->INTELLECT;
    }

    public function setINTELLECT(int $INTELLECT): self
    {
        $this->INTELLECT = $INTELLECT;

        return $this;
    }

    public function getPER(): ?int
    {
        return $this->PER;
    }

    public function setPER(int $PER): self
    {
        $this->PER = $PER;

        return $this;
    }

    public function getCHA(): ?int
    {
        return $this->CHA;
    }

    public function setCHA(int $CHA): self
    {
        $this->CHA = $CHA;

        return $this;
    }

    public function getAGI(): ?int
    {
        return $this->AGI;
    }

    public function setAGI(int $AGI): self
    {
        $this->AGI = $AGI;

        return $this;
    }

    public function getLUC(): ?int
    {
        return $this->LUC;
    }

    public function setLUC(int $LUC): self
    {
        $this->LUC = $LUC;

        return $this;
    }

    public function getEND(): ?int
    {
        return $this->END;
    }

    public function setEND(int $END): self
    {
        $this->END = $END;

        return $this;
    }
}
