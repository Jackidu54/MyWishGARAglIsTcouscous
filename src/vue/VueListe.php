<?php
namespace mywishlist\vue;
use mywishlist\controleur\ControleurUrl;
use mywishlist\models\User;
use mywishlist\controleur\Authentication;

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
        $inscription = ControleurUrl::urlName('inscription');
        if ($this->selecteur == self::$AFFICHE_1_LISTE) {
            $liste = $this->modele;
            $message="";
            $user = User::select()->where('id', '=', $liste->user_id)->first();
            $pseudo = $user->pseudo;
            $app =\Slim\Slim::getInstance();
            $rootUri = $app->request->getRootUri();
            $itemUrl = $app->urlFor('createur_item', ['id'=> $liste->no]);
            $itemMessage = $app->urlFor('creer_message', ['id'=> $liste->no]);
            $urlAjouterItem = $rootUri . $itemUrl;
            $urlItemMessage = $rootUri . $itemMessage;
            
            if (isset($liste->message)) {
                $message=<<<html
<p>$liste->message</p>
html;
            }
            $contenu = <<<html
<h1>Wishliste $liste->titre</h1>
<p>description : $liste->description </p>  
<p>Expire le : $liste->expiration</p>
$message
<p>Crée par l'utilisateur : $pseudo</p>
<ol>

html;
            $items = $liste->items();
            foreach ($items as $item) {
                $contenu = $contenu . <<<html
<li>
<a href="/item/display/$item->id">
<p class="descritem">$item->nom, etat de reservation : non reservé</p>
<img src="/web/img/$item->img" alt="$item->img">
</a>
</li>
html;
            }
            if (isset($liste->message)) {
                $message = $liste->message;
                $formulaire = <<<html
<form id="modifMessage" method="post" action="$urlItemMessage">
<label>modifier le message de la liste</label>
<input type="text" id="messageliste" name="message" value="$message">
<button type="submit" name="valid" >Valider</button>
</form>   
html;
            } else {
                $formulaire = <<<html
<form id="ajoutMessage" method="post" action="$urlItemMessage">
<label>ajouter un message de la liste</label>
<input type="text" id="messageliste" name="message">
<button type="submit" name="valid" >Valider</button>
</form> 
            
html;
            }
            
            $contenu = $contenu . <<<html
</ol>
<form id="ajoutItem" method="post" action="$urlAjouterItem">
<button type="submit" name="valid" >ajouter un nouvel item</button>
</form>
<br>
$formulaire
html;
        }
        if ($this->selecteur == self::$AFFICHE_LISTES) {
            $app =\Slim\Slim::getInstance();
            $rootUri = $app->request->getRootUri();
            $contenu = <<<html
<h1>Mes WishListes</h1>
  <p>Veuillez sélectionner votre liste dans cette liste de liste</p>
  <ul>
html;
            foreach ($this->modele as $liste) {
                $afficherListeUrl = $app->urlFor('affiche_1_liste', ['id'=> $liste->no]);
                $url1liste = $rootUri . $afficherListeUrl;
                $contenu = $contenu . <<<html
    <li id="liste_affichee"><a href="$url1liste">$liste->titre</a>
	<form id="suprlist" method="post" action="/liste/delete/$liste->no"><button type="submit" name="valid" >supprimer la liste</button></form>
	<form id="modlist" method="post" action="/liste/modify/$liste->no"><button type="submit" name="valid" >Modifier la liste</button></form></li>
html;
            }
            
            $contenu = $contenu . <<<html
  </ul>
html;
        }
        if ($this->selecteur == self::$CREATION_LISTE) {
            $contenu = <<<html
<h1>Creation d'une nouvelle liste</h1>
<form id="formcreationliste" method="post" action="/liste/create/valide">

    <label for"formnomliste">nom de la liste</label>
    <input type="text" id="formnomliste" name="titre" required placeholder="<nom de la liste>">

    <label for"formdescliste">description de la liste</label>    
    <input type="text" id="formdescliste" name="description" required placeholder="<description de la liste>">

    <button type="submit" name="valid" >Créer</button>
</form>
html;
        }
        if ($this->selecteur == self::$MODIFY_LISTE) {
            $liste = $this->modele;
            $contenu = <<<html
<h1>Modification d'une liste</h1>
<h2>liste choisie : </h2>
<form id="formmodifliste" method="post" action="/liste/modify/valide/$liste->no">

    <label for"formnomliste">nom de la liste</label>
    <input type="text" id="formnomliste" name="titre" value="$liste->titre">

    <label for"formdescliste">description de la liste</label>    
    <input type="text" id="formdescliste" name="description" value="$liste->description">

    <button type="submit" name="valid" >Enregistrer modification</button>
</form>
html;
        }
        $urlPannel = ControleurUrl::urlId('pannel', 0);
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
    <li><a href="$inscription">Se déconnecter</a></li>
    <li><a href="/liste/display">Affiche mes listes</a></li>
    <li><a href="/liste/create">Créer une liste</a></li>
    <li><a href="$urlPannel">Parametres</a></li>
html;
    if(Authentication::checkAccessRights(Authentication::$ACCESS_SUP_ADMIN)){
        $url = ControleurUrl::urlName('listes_all');
        $html = $html . <<<html
    <li><a href="$url">Afficher toutes les listes</a></li>
html;
    }
    $html = $html . <<<html
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

