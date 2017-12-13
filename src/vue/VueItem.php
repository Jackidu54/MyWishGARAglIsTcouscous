<?php
namespace mywishlist\vue;

class VueItem
{
    public static $AFFICHER_1_ITEM=0;
    public static $RESERVE_ITEM=1;
    public static $ANNULER_ITEM=2;
    public static $CREATION_MESSAGE=3;
    private $selecteur;
    private $model;
    function __construct($select,$modele){
        $this->selecteur=$select;
        $this->model=$modele;
    }
    
    function render()
    {
        $contenu = "";
        if ($this->selecteur == self::$AFFICHER_1_ITEM) {
            $tmp=$this->model;
            $contenu = <<<html
<h1>Affiche un item</h1>
html;
            $contenu = $contenu.<<<html
    <a>$tmp->nom : $tmp->descr </a>
html;
            
            $contenu=$contenu.<<<html
html;
            
        }
            
        if ($this->selecteur == self::$RESERVE_ITEM) {}
        if ($this->selecteur == self::$ANNULER_ITEM) {}
        if ($this->selecteur == self::$CREATION_MESSAGE) {}
        
        
        $html = <<<html
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="/web/css/style.css">
  
  
</head>
<body>

<div class="container">

<header>
   <h1>Liste de Cadeaux</h1>
</header>

<nav>
  <ul>
    <li><a href="#">Cr�er un compte</a></li>
    <li><a href="#">Se connecter</a></li>
    <li><a href="#">Affiche mes listes</a></li>
    <li><a href="#">Cr�er une liste</a></li>
    <li><a href="#">Modifier une liste</a></li>
    <li><a href="#">Afficher une liste</a></li>
    <li><a href="#">Ordonner les items</a></li>
  </ul>
</nav>

<article>
  $contenu
</article>

<footer>
<div id="gauche">
Petit message de paix d'amour et d'amiti�
</div>
<div id="droite">
Copyright
</div>

</footer>

</div>

</body>
</html>
html;
        return $html;
    }
}

