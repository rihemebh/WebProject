<?php

namespace App\Entity;

use App\Repository\PayementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PayementRepository::class)
 */
class Payement
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
    private $numPayement;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cardId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cardPass;

    /**
     * @ORM\Column(type="date")
     */
    private $datePayement;

    /**
     * @ORM\Column(type="time")
     */
    private $timePayement;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="payements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $forUser;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumPayement(): ?string
    {
        return $this->numPayement;
    }

    public function setNumPayement(string $numPayement): self
    {
        $this->numPayement = $numPayement;

        return $this;
    }

    public function getCardId(): ?int
    {
        return $this->cardId;
    }

    public function setCardId(?int $cardId): self
    {
        $this->cardId = $cardId;

        return $this;
    }

    public function getCardPass(): ?int
    {
        return $this->cardPass;
    }

    public function setCardPass(?int $cardPass): self
    {
        $this->cardPass = $cardPass;

        return $this;
    }

    public function getDatePayement(): ?\DateTimeInterface
    {
        return $this->datePayement;
    }

    public function setDatePayement(\DateTimeInterface $datePayement): self
    {
        $this->datePayement = $datePayement;

        return $this;
    }

    public function getTimePayement(): ?\DateTimeInterface
    {
        return $this->timePayement;
    }

    public function setTimePayement(\DateTimeInterface $timePayement): self
    {
        $this->timePayement = $timePayement;

        return $this;
    }

    public function getForUser(): ?User
    {
        return $this->forUser;
    }

    public function setForUser(?User $forUser): self
    {
        $this->forUser = $forUser;

        return $this;
    }

}
