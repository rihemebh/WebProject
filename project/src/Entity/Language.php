<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LanguageRepository::class)
 */
class Language
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Livre::class, mappedBy="language")
     */
    private $book;

    public function __construct()
    {
        $this->book = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Livre[]
     */
    public function getBook(): Collection
    {
        return $this->book;
    }

    public function addBook(Livre $book): self
    {
        if (!$this->book->contains($book)) {
            $this->book[] = $book;
            $book->setLanguage($this);
        }

        return $this;
    }

    public function removeBook(Livre $book): self
    {
        if ($this->book->contains($book)) {
            $this->book->removeElement($book);
            // set the owning side to null (unless already changed)
            if ($book->getLanguage() === $this) {
                $book->setLanguage(null);
            }
        }

        return $this;
    }
}
