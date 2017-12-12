<?php
namespace mywishlist\vue;

class VueItem
{
    public static $AFFICHER_1_ITEM=0;
    public static $RESERVE_ITEM=1;
    public static $ANNULER_ITEM=2;
    public static $CREATION_MESSAGE=3;
    public $selecteur;
    function __construct($select){
        $this->selecteur=$select;
    }
    function render(){
        $contenu="<p>html</p>";
        $html=<<<debut
debut;
        return $html;
    }
    
    
    
    
}

