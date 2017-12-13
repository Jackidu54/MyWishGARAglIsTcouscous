<?php
namespace mywishlist\vue;

class VueListe
{

    public static $AFFICHE_1_LISTE = 0;

    public static $AFFICHE_LISTES = 1;

    public static $CREATION_LISTE = 2;

    public static $MODIFY_LISTE = 3;

    private $selecteur;

    private $modele;

    function __construct($select, $model)
    {
        $this->selecteur = $select;
        $this->modele = $model;
    }

    function render()
    {
        $contenu = "";
        if ($this->selecteur == self::$AFFICHE_1_LISTE) {}
        if ($this->selecteur == self::$AFFICHE_LISTES) {
            $contenu = <<<html
<h1>Affiche mes Listes</h1>
  <p>Veuillez sélectionner votre liste dans cette liste de liste</p>
  <ul>
html;
         foreach ($this->modele as $liste){   
            $contenu = $contenu.<<<html
    <li><a href="/liste/display/$liste->no">$liste->titre</a></li>
html;
        }
           
        $contenu=$contenu.<<<html
  </ul>
html;
        }
        if ($this->selecteur == self::$CREATION_LISTE) {}
        if ($this->selecteur == self::$MODIFY_LISTE) {}
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
    <li><a href="#">Créer un compte</a></li>
    <li><a href="#">Se connecter</a></li>
    <li><a href="#">Affiche mes listes</a></li>
    <li><a href="#">Créer une liste</a></li>
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
Petit message de paix d'amour et d'amitié
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

