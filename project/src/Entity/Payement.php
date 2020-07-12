<?php

namespace App\Entity;

use App\Repository\PayementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="This field can not be empty")
     */
    private $datePayement;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="This field can not be Empty")
     */
    private $timePayement;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="payements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $forUser;

    /**
     * @ORM\Column(type="array")
     */
    private $books = [];

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $typePayement;


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

    public function getDatePayement(): ?string
    {
        return $this->datePayement;
    }

    public function setDatePayement(string $datePayement): self
    {
        $this->datePayement = $datePayement;

        return $this;
    }

    public function getTimePayement(): ?string
    {
        return $this->timePayement;
    }

    public function setTimePayement(string $timePayement): self
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

    public function getBooks(): ?array
    {
        return $this->books;
    }

    public function setBooks(array $books): self
    {
        $this->books = $books;

        return $this;
    }

    public function getTypePayement(): ?string
    {
        return $this->typePayement;
    }

    public function setTypePayement(string $typePayement): self
    {
        $this->typePayement = $typePayement;

        return $this;
    }

}
