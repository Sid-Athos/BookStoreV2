<?php

namespace App\Entity;

use App\Repository\RentalLinesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RentalLinesRepository::class)
 */
class RentalLines
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Rentals::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Rental;

    /**
     * @ORM\ManyToOne(targetEntity=Articles::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Article;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRental(): ?Rentals
    {
        return $this->Rental;
    }

    public function setRental(?Rentals $Rental): self
    {
        $this->Rental = $Rental;

        return $this;
    }

    public function getArticle(): ?Articles
    {
        return $this->Article;
    }

    public function setArticle(?Articles $Article): self
    {
        $this->Article = $Article;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
}
