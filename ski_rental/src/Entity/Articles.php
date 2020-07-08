<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 */
class Articles
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity=Marques::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Marques;

    /**
     * @ORM\Column(type="float")
     */
    private $DailyPrice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getMarques(): ?Marques
    {
        return $this->Marques;
    }

    public function setMarques(?Marques $Marques): self
    {
        $this->Marques = $Marques;

        return $this;
    }

    public function getDailyPrice(): ?float
    {
        return $this->DailyPrice;
    }

    public function setDailyPrice(float $DailyPrice): self
    {
        $this->DailyPrice = $DailyPrice;

        return $this;
    }
}
