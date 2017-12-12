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
    }

    function creerListe($user, $titre, $description)
    {
    	$date = date("Y-m-d", strtotime("+1 year"));
        $l = new Liste();
        $l->user_id = $user;
        $l->titre = $titre;
        $l->description = $description;
        $l->expiration = $date;
        $l->save();
    }


    function modifierListe($no,$titre,$description){
    	$liste = Liste::select()->where('no', '=', $num)->first();
    	$liste->titre = $titre;
    	$liste->description = $description;
    	$liste->expiration = date("Y-m-d", strtotime("+1 year"));
    	$l->save();
    }

    function ajouterMessage($id, $message){
    	$liste = Liste::select()->where('no', '=', $id)->first();
    	$liste->message = $message;
    	$liste->save();
    }
}