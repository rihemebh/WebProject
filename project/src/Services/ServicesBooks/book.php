<?php


namespace App\Services\ServicesBooks;


use App\Repository\LivreRepository;

class Book
{
private $repo;

public function __construct(LivreRepository $livre)
{
    $this->repo=$livre;
}
//    public function slugify($livre): string
//    {
//        $name = $livre->getNomLivre();
//        $slug = str_replace(' ', '-', $name);
//        $transliterator = \Transliterator::createFromRules(':: NFD; :: [:Nonspacing Mark:] Remove; :: Lower(); :: NFC;', \Transliterator::FORWARD);
//        $slug = $transliterator->transliterate($slug);
//        $slug = preg_replace('/[^a-z0-9\-]/i', '', $slug);
//
//        $lastlivre = $this->repo->findDuplicateSlug($livre->getId(), $slug);
//
//        if ($lastlivre) {
//            $lastSlug = $lastlivre->getSlug();
//            $lastChar = mb_substr($lastSlug, -1);
//            if (is_numeric($lastChar)) {
//                $lastChar++;
//                $slug .= '-' . $lastChar;
//            } else {
//                $slug .= '-1';
//            }
//        }
//
//        return $slug;
//    }
}