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
        $listes = Liste::select()->where('no', '=', $num)->get();
        foreach ($listes as $liste) {
            echo $liste . "<br>";
        }
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