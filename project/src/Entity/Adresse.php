<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdresseRepository")
 */
class Adresse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $code_postale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePostale(): ?int
    {
        return $this->code_postale;
    }

    public function setCodePostale(?int $code_postale): self
    {
        $this->code_postale = $code_postale;

        return $this;
    }

    public function getNomAdresse(): ?string
    {
        return $this->nom_adresse;
    }

    public function setNomAdresse(string $nom_adresse): self
    {
        $this->nom_adresse = $nom_adresse;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }
}
