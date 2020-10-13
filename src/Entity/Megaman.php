<?php

namespace App\Entity;

use App\Repository\MegamanRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MegamanRepository::class)
 */
class Megaman
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("megamen_list")
     */
    private int $id;

    /**
     * @ORM\Column(type="date")
     */
    private DateTimeInterface $birth_date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("megamen_list")
     */
    private string $name;

    /**
     * @ORM\OneToOne(targetEntity=Body::class, inversedBy="megaman", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Body $body;

    /**
     * @ORM\Column(type="integer")
     */
    private int $STR;

    /**
     * @ORM\Column(type="integer")
     */
    private int $INTELLECT;

    /**
     * @ORM\Column(type="integer")
     */
    private int $PER;

    /**
     * @ORM\Column(type="integer")
     */
    private int $CHA;

    /**
     * @ORM\Column(type="integer")
     */
    private int $AGI;

    /**
     * @ORM\Column(type="integer")
     */
    private int $LUC;

    /**
     * @ORM\Column(type="integer")
     */
    private int $END;

    public function getId(): ?int
    {
        return $this->id;
    }

    // Симфони видит в шаблоне название сеттера, только если он именован "get".имя_свойства
    public function getbirth_date(): ?DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setbirth_date(DateTimeInterface $birth_date): self
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

    // Для административной панели
    public function __toString() 
    {
        return $this->getName();
    }
}
