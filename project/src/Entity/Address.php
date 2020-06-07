<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="City Cannot Contain A Number" )
     *
     * @Assert\NotBlank( message = " This Field Cannot Be Empty ")
     */
    private $City;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message = " This Field Cannot Be Empty ")
     * @Assert\Positive (message="Invalid Code")
     * @Assert\Length(
     *      min = 4,
     *      max = 4,
     *     exactMessage="Code Must be 4 digit long"
     * )
     */
    private $Code;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="address")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Street;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $House_address_number;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(string $Code): self
    {
        $this->Code = $Code;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAddress($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getAddress() === $this) {
                $user->setAddress(null);
            }
        }

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->Street;
    }

    public function setStreet(?string $Street): self
    {
        $this->Street = $Street;

        return $this;
    }

    public function getHouseAddressNumber(): ?int
    {
        return $this->House_address_number;
    }

    public function setHouseAddressNumber(?int $House_address_number): self
    {
        $this->House_address_number = $House_address_number;

        return $this;
    }
}
