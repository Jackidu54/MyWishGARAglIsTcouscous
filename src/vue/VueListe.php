<?php
namespace mywishlist\vue;

class VueListe
{
    public static $AFFICHE_1_LISTE=0;
    public static $AFFICHE_LISTES=1;
    public static $CREATION_LISTE=2;
    public static $MODIFY_LISTE=3;
    
    private $selecteur;
    function __construct($select){
        $this->selecteur=$select;
    }
    
}

