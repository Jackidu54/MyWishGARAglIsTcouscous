<?php
namespace mywishlist\controleur;

use mywishlist\models\Liste;

class ControleurListe
{

	function dernierNo(){
		$listes = Liste::select('no')->get();
		foreach ($listes as $res=>$val){
			echo $res;
			$return = $res;
		}
		
		return $return;
	}

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


    function modifierListe($no,$user_id,$titre,$description,$expiration){
    	$liste = Liste::select()->where('no', '=', $num)->first();
    	$liste->user_id = $user_id;
    	$liste->titre = $titre;
    	$liste->description = $description;
    	$liste->expiration = $expiration;
    	$l->save();
    }
}