<?php


namespace App\Entity;


class PropertySearch  {

    /**
     * @var String|null
     */
    private $author ;
    /**
     * @var String|null
     */
    private $user_Name ;
    /**
     * @var float|null
     */
    private $maxPrice;
    /**
     * @var String|null
     */
    private $nom_livre ;




    /**
     * @var String|null
     */
    private $User_Name ;
    /**
     * @return String|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param String|null $author
     * @return PropertySearch
     */
    public function setAuthor(string $author): PropertySearch
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getMaxPrice(): ?float
    {
        return $this->maxPrice;
    }
    /**
     * @return String|null
     */
    public function getUserName(): ?string
    {
        return $this->user_Name;
    }
    /**
     * @return String|null
     */
    public function getNomLivre(): ?string
    {
        return $this->nom_livre;
    }

    /**
     * @param String|null $user_Name
     * @return PropertySearch
     */
    public function setUserName(string $user_Name): PropertySearch
    {
        $this->user_Name = $user_Name;
        return $this;
    }

    /**
     * @param String|null $nom_livre
     * @return PropertySearch
     */
    public function setNomLivre(string $nom_livre): PropertySearch
    {
        $this->nom_livre = $nom_livre;
        return $this;
    }
    /**
     * @param float|null $maxPrice
     * @return PropertySearch
     */
    public function setMaxPrice(float $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }


    /**
     * @return Categorie[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param Categorie[] $categories
     * @return PropertySearch
     */
    public function setCategories(array $categories): PropertySearch
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @var Categorie[]
     */
    public $categories = [];
    /**
     * @var Language[]
     */
    public $languages = [];

}