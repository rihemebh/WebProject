<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields = {"Email"},
 *     message = "Email Already Used"
 * )
 *
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message = " This Field Cannot Be Empty ")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="First Name Cannot Contain A Number" )
     */
    private $First_Name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message = " This Field Cannot Be Empty ")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Last Name Cannot Contain A Number" )
     */
    private $Last_Name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message = " This Field Cannot Be Empty ")
     * @Assert\Email( message = "Invalid Email Address")
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message = " This Field Cannot Be Empty ")
     * @Assert\Length(
     *      min = 2,
     *     minMessage="At Least 8 Characters",
     *     )
     */
    private $Password;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message = " This Field Cannot Be Empty ")
     * @Assert\Positive (message="Invalid Phone Number")
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *     exactMessage="Phone Number Must be 8 digit long"
     * )
     */
    private $Phone_Number;




    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message = " This Field Cannot Be Empty ")
     */
    private $User_Name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Address;

    /**
     * @ORM\ManyToMany(targetEntity=Livre::class, mappedBy="Likes")
     */
    private $BooksLiked;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $activation_token;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $reset_token;


    public function __construct()
    {
        $this->BooksLiked = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->First_Name;
    }

    public function setFirstName(string $First_Name): self
    {
        $this->First_Name = $First_Name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->Last_Name;
    }

    public function setLastName(string $Last_Name): self
    {
        $this->Last_Name = $Last_Name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->Phone_Number;
    }

    public function setPhoneNumber(string $Phone_Number): self
    {
        $this->Phone_Number = $Phone_Number;

        return $this;
    }



    public function getUserName(): ?string
    {
        return $this->User_Name;
    }

    public function setUserName(string $User_Name): self
    {
        $this->User_Name = $User_Name;

        return $this;
    }
    public function eraseCredentials(){}
    public function getSalt(){}
    public function getRoles(){
        return array('ROLE_USER');
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(?string $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    /**
     * @return Collection|Livre[]
     */
    public function getBooksLiked(): Collection
    {
        return $this->BooksLiked;
    }

    public function addBooksLiked(Livre $booksLiked): self
    {
        if (!$this->BooksLiked->contains($booksLiked)) {
            $this->BooksLiked[] = $booksLiked;
            $booksLiked->addLike($this);
        }

        return $this;
    }

    public function removeBooksLiked(Livre $booksLiked): self
    {
        if ($this->BooksLiked->contains($booksLiked)) {
            $this->BooksLiked->removeElement($booksLiked);
            $booksLiked->removeLike($this);
        }

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): self
    {
        $this->activation_token = $activation_token;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): self
    {
        $this->reset_token = $reset_token;

        return $this;
    }


}
?>