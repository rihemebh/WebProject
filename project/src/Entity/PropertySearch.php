<?php


namespace App\Entity;


class PropertySearch{

    /**
     * @var String|null
     */
    private $author ;
    /**
     * @var float|null
     */
    private $maxPrice;





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
     * @param float|null $maxPrice
     * @return PropertySearch
     */
    public function setMaxPrice(float $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

//    /**
//     * @return string
//     */
//    public function getQ(): string
//    {
//        return $this->q;
//    }
//
//    /**
//     * @param string $q
//     * @return PropertySearch
//     */
//    public function setQ(string $q): PropertySearch
//    {
//        $this->q = $q;
//        return $this;
//    }

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

//    /**
//     * @var string
//     */
//    public $q ="";
    /**
     * @var Categorie[]     */
    public $categories =[];



}