<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class SearchCategory
{
    /**
     * @var ArrayCollection
     */
    private $categories ;

    /**
     * @return ArrayCollection
     */
    public function getCategories(): ArrayCollection
    {
        return $this->categories;
    }

    /**
     * @param ArrayCollection $categories
     * @return SearchCategory
     */
    public function setCategories(ArrayCollection $categories): SearchCategory
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * SearchCategory constructor.
     *
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }
}