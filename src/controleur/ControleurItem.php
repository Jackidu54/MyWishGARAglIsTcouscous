<?php
namespace mywishlist\controleur;

use mywishlist\models\Liste;

public class ControleurItem{
	
	function afficherItems()
    {
        $items = Liste::select()->get();
        foreach ($items as $item) {
            echo $item . "<br>";
        }
    }

    function afficherItems($num)
    {
        $items = Liste::select()->where('id', '=', $num)->get();
        foreach ($items as $item) {
            echo $item . "<br>";
        }
    }
}
