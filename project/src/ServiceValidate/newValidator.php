<?php


namespace App\ServiceValidate;


use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

class newValidator
{
// en edit le formulaire retourne une exception si on lui fournit des champs vide
// ce service est créé pour manuellement empecher l utilisateur de passer des valeurs nulles

    public function validform(Form $form)
    {
        if (!$form->get('First_Name')->getData()) {
            $form->add(new FormError('Empty Field'));
        }
        if (!$form->get('Last_Name')->getData()) {
            $form->add(new FormError('Empty Field'));
        }
        if (!$form->get('User_Name')->getData()) {
            $form->add(new FormError('Empty Field'));
        }
        if (!$form->get('Email')->getData()) {
            $form->add(new FormError('Empty Field'));
        }
        if (!$form->get('Phone_Number')->getData()) {
            $form->add(new FormError('Empty Field'));
        }
    }

}