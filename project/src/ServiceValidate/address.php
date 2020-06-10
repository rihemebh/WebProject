<?php


namespace App\ServiceValidate;


use Symfony\Component\Form\Form;

class address
{
public function create(Form $form) :string
{
    $data = $form->getData();
    $ad = '';
    foreach ($data as $key => $value) {
        $ad = $ad . $value . ' ';
    }
    $ad = trim($ad);
    return $ad;
}}