<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 */
class Facture
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
    private $date_pub;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_facture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePub(): ?\DateTimeInterface
    {
        return $this->date_pub;
    }

    public function setDatePub(\DateTimeInterface $date_pub): self
    {
        $this->date_pub = $date_pub;

        return $this;
    }

    public function getNumFacture(): ?int
    {
        return $this->num_facture;
    }

    public function setNumFacture(int $num_facture): self
    {
        $this->num_facture = $num_facture;

        return $this;
    }
}
