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
        $liste = Liste::select()->where('no', '=', $num)->first();
        echo $liste;
        /*foreach ($listes as $liste) {
        	echo $liste;
        }*/
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