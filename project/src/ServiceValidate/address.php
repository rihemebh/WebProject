<?php


namespace App\ServiceValidate;



use phpDocumentor\Reflection\Types\Boolean;
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
}
public function confirmaddress(Form $form): string
{
        if (!$form->get('City')->getData() || !$form->get('Code')->getData() ) {
            return "Code And City Are Both Required";
        }
        elseif(strlen($form->get('Code')->getData()) !==4)
             return "Code Is A 4 Digit Number";
        return "";
}

}