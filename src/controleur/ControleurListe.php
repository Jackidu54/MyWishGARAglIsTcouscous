<?php
namespace mywishlist\controleur;

use mywishlist\models\Liste;

class ControleurListe
{

    function afficherListes()
    {
        $listes = Liste::select()->get();
        foreach ($listes as $liste) {
            echo $liste . "<br>";
        }
    }

    function afficherListe($num)
    {
<<<<<<< HEAD
        $listes = Liste::select()->where('id', '=', $num)->get()->first();
=======
        $listes = Liste::select()->where('no', '=', $num)->get();
        foreach ($listes as $liste) {
>>>>>>> 458139a9bc30f20cde997562d17a4b845a3710bd
            echo $liste . "<br>";
    }

    function creerListe($user, $titre, $description)
    {
        $l = new Liste();
        $l->user = $user;
        $l->titre = $titre;
        $l->description = $description;
        $l->save();
    }
}