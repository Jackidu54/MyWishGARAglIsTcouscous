<?php
namespace mywishlist\vue;
use mywishlist\controleur\ControleurUrl;
use mywishlist\models\User;
use mywishlist\models\Liste;
use mywishlist\models\Guest;
use mywishlist\controleur\Authentication;

class VueListe
{

    public static $AFFICHE_1_LISTE = 0;

    public static $AFFICHE_LISTES = 1;

    public static $CREATION_LISTE = 2;

    public static $MODIFY_LISTE = 3;

    public static $DISPLAY_CONTRI = 4;

    public static $AFFICHE_ALL = 5;
    
    public static $PARTAGE=6;

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
        $inscription = ControleurUrl::urlName('connection');
        if ($this->selecteur == self::$AFFICHE_1_LISTE) {
            $liste = $this->modele;
            $message="";
            $user = User::select()->where('id', '=', $liste->user_id)->first();
            $pseudo = $user->pseudo;
            $app =\Slim\Slim::getInstance();
            $rootUri = $app->request->getRootUri();
            $partageurl = ControleurUrl::urlId('partager_liste', $liste->no);
            $urlitemMessage = ControleurUrl::urlId('creer_message', $liste->no);
            $urlAjouterItem = ControleurUrl::urlId('createur_item', $liste->no);
            $urlapartager= "http://".$_SERVER['SERVER_NAME'] . ControleurUrl::urlId('afficher_liste_partagee', $liste->token);
            $urlAjouterItem = ControleurUrl::urlId('createur_item', $liste->no);
            
            $partage="";
            if ($liste->token==null || strstr($liste->token, "nosecure")){
                $partage=<<<html
<form id="partagItem" method="post" action="$partageurl"><button type="submit" name="valid" >initialiser le partage</button></form>            
html;
            }
            else{
                $partage=<<<html
<p>Lien de partage : <a href="$urlapartager">$urlapartager</a> </p>            
html;
            }
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
$partage
<table>
<tr>
       <th></th>
       <th>Ttire</th>
       <th>Etat de reservation</th>
       <th></th>
       <th>Tarif</th>
       <th></th>
</tr>
html;
            $items = $liste->items();
            $compteuritem=0;
            foreach ($items as $item) {
                $compteuritem++;
                $urlversitem=ControleurUrl::urlId('affiche_1_item',$item->id);
                $contenu = $contenu . <<<html
<tr>
<td><p id="compteuritem">$compteuritem</p></td>
<td><a href="$urlversitemControleurUrl"><p class="descritem">$item->nom</p></td></a>
<td><p>$item->reserve</p></td>
<td><img src="/www/jacque14u/ProjetPhp/web/img/$item->img" alt="$item->img"></td>
<td><p>$item->tarif €</p></td>

html;
                if($liste->user_id==$_SESSION['profile']['id'] || Authentication::checkAccessRights(Authentication::$ACCESS_ADMIN)){
                    $suprItem = ControleurUrl::urlId('delete_item', $item->id);
                    $contenu =$contenu.<<<html
                    <td>
                    <form id="supprItem" method="post" action="$suprItem">
                    <input type="hidden" name="listeid" value="$liste->no">
                    <button type="submit" name="valid" class="mon_fichier-label">Supprimer</button></form>
                    </td>
html;
                }
                $contenu=$contenu.<<<html
</tr>
html;
            }
            if (isset($liste->message)) {
                $message = $liste->message;
                $formulaire = <<<html
<form id="modifMessage" method="post" action="$urlitemMessage">
<label>Modifier le message de la liste</label>
<input type="text" id="messageliste" name="message" value="$message">
<div class="formParam"><button type="submit" name="valid" >Valider</button></div>
</form>   
html;
            } else {
                $formulaire = <<<html
<form id="ajoutMessage" method="post" action="$urlitemMessage">
<label>Ajouter un message de la liste :</label>
<input type="text" id="messageliste" name="message">
<div class="formParam"><button type="submit" name="valid" >Valider</button></div>
</form> 
            
html;
            }
            
            $contenu = $contenu . <<<html
</table>
<div class="formAddItem"><a href="$urlAjouterItem"><button type="submit" name="valid" >Ajouter un nouvel item</button></a></div>
<br>
$formulaire
html;
        }

        if($this->selecteur == self::$DISPLAY_CONTRI) {
            $liste = $this->modele;
            $propr = User::select()->where('id', '=', $liste->user_id)->first();
            $proprio = $propr->pseudo;
            $ids = Guest::select()->where('liste_id', '=', $liste->no)->get();

            $users = array();

            foreach($ids as $guest){
                $id = $guest->user_id;
                $user = User::select()->where('id', '=', $id)->get()->first();
                array_push($users, $user);
            }

            $contenu = <<<html
            <h2>Liste appartenant à : $proprio</h2>
html;
            $contenu = $contenu.<<<html
            <h3>Liste des gérants</h3>
            <ul>
html;
            foreach($users as $user){
                    if(Authentication::checkAccessRights(Authentication::$ACCESS_ADMIN) && $liste->user_id != $_SESSION['profile']['id']){
                        //$message = $_SESSION['profile']['pseudo'] . ", voulez vous supprimer $user->pseudo des invités de $proprio ?";
                    }else{
                        $message = "Êtes-vous sur de vouloir supprimer $user->pseudo de votre liste?";
                    }
                    if($user->pseudo == $_SESSION['profile']['pseudo']){
                        $pseudo = "Vous"; 
                    }else $pseudo = "$user->pseudo";
                    $urlsuppressionguest=\Slim\Slim::getInstance()->urlFor('supprimer_guest', ['no'=> $liste->no],['id'=> $user->id]);
                    $contenu = $contenu . <<<html
                    <li id="liste_affichee">$pseudo
                    <form id="suprlist" method="post" action="$urlsuppressionguest" onsubmit="return confirmation();"><button type="submit" name="valid">supprimer de la liste</button></form>
                    </p>
                    </li>
                    <script>
                        function confirmation(){
                            return confirm("$message");
                        } 
                    </script> 
html;
            }
            $contenu = $contenu . <<<html
             </ul>
html;

        if($liste->user_id==$_SESSION['profile']['id'] || Authentication::checkAccessRights(Authentication::$ACCESS_ADMIN)){
            $urlajouterguest=ControleurUrl::urlId('ajouter_guest',$liste->no)
            $contenu = $contenu . <<<html
             <form id="addUser" method="post" action="$urlajouterguest">
            <label>Ajouter un utilisateur</label>
            <input type="text" id="pass" name="pseudo" class="champ_con" required placeholder="Entrez un pseudo valide">
            <button type="submit" name="valid" class="formParam">Ajouter</button>
            </form>
html;
        }
    }
        if ($this->selecteur == self::$AFFICHE_LISTES || $this->selecteur == self::$AFFICHE_ALL) {
            $app =\Slim\Slim::getInstance();
            if($this->selecteur == self::$AFFICHE_LISTES){
                $titre = "Voici vos listes :";
            }else $titre = "Toutes les listes enregistrées";
            $contenu = <<<html
<p><img src="/www/jacque14u/ProjetPhp/web/img/mesCadeaux.png" style="float:left"><h1>Mes WishListes</h1></p>
  <p>$titre</p>
  <div id="listes">
    <ul class="rounded-list">
html;
            foreach ($this->modele as $liste) {
                $afficherListeUrl = $app->urlFor('affiche_1_liste', ['id'=> $liste->no]);
                $url1liste =  $afficherListeUrl;
                $temp = $app->urlFor('contributeurs', array('id' => $liste->no));
                $urlContrib =  $temp;
                $urlallluser=ControleurUrl::getId('contributeurs',$liste->no);
                $urlsupressionliste=ControleurUrl::getId('supprimer_liste',$liste->no);
                $urlmodifierliste=ControleurUrl::getId('modifie_liste',$liste->no);
                $contenu = $contenu . <<<html
    <a href="$url1liste"><li class="liste_affichee">$liste->titre
    <a id="suprlist" href="$urlallluser"><button type="submit" name="valid" class="boutonListes">Contributeurs</button></a>
	<form id="suprlist" method="post" action="$urlsupressionliste"><button type="submit" name="valid" class="boutonListes">Supprimer la liste</button></form>
	<form id="modlist" method="post" action="$urlmodifierliste"><button type="submit" name="valid" class="boutonListes">Modifier la liste</button></form>
</li></a>
html;
            }
            
            $contenu = $contenu . <<<html
  </ul>
</div>
html;
        }
        if ($this->selecteur == self::$CREATION_LISTE) {
            $urllistecreation=ControleurUrl::urlName('validation_liste');
            $contenu = <<<html
<h1>Creation d'une nouvelle liste</h1>
<form id="formcreationliste" method="post" action="$urllistecreation">

    <label for"formnomliste">Nom de la liste</label>
    <input type="text" id="formnomliste" name="titre" required placeholder="<nom de la liste>">

    <label for"formdescliste">Description de la liste</label>    
    <input type="text" id="formdescliste" name="description" required placeholder="<description de la liste>">

    <div class="formCreationListe"><button type="submit" name="valid" >Créer</button></form>
</form>
html;
        }
        if ($this->selecteur == self::$MODIFY_LISTE) {
            $urlmodifiervliste=ControleurUrl::getId('valide_liste',$liste->no);
            $liste = $this->modele;
            $contenu = <<<html
<h1>Modification d'une liste</h1>
<h2>Liste choisie : "$liste->titre"</h2>
<form id="formmodifliste" method="post" action="$urlmodifiervliste">

    <label for"formnomliste">Nom de la liste</label>
    <input type="text" id="formnomliste" name="titre" value="$liste->titre">

    <label for"formdescliste">Description de la liste</label>    
    <input type="text" id="formdescliste" name="description" value="$liste->description">

    <div class="formMod"><button type="submit" name="valid" >Enregistrer modification</button></div>
</form>
html;
        }
            
        if ($this->selecteur == self::$PARTAGE) {
            $liste = $this->modele;
            $message="";
            $user = User::select()->where('id', '=', $liste->user_id)->first();
            $pseudo = $user->pseudo;
            if (isset($liste->message)) {
                $message=<<<html
<p>$liste->message</p>
html;
            }
            $contenu = <<<html
<h1>Wishliste : $liste->titre</h1>
<p>description : $liste->description </p>
<p>Expire le : $liste->expiration</p>
$message
<p>Crée par l'utilisateur : $pseudo</p>
<table>
<tr>
       <th></th>
       <th>Ttire</th>
       <th>Etat de reservation</th>
       <th></th>
       <th></th>
</tr>
html;
            $items = $liste->items();
            $compteuritem=0;
            foreach ($items as $item) {
                $compteuritem++;
                $urlversitem2=ControleurUrl::urlId('affiche_1_item',$item->id);
                $contenu = $contenu . <<<html
<tr>
<td><p id="compteuritem">$compteuritem</p></td>
<td><a href="$urlversitem2"><p class="descritem">$item->nom</p></td></a>
<td><p>$item->reserve</p></td>
<td><img src="/www/jacque14u/ProjetPhp/web/img/$item->img" alt="$item->img"></td>

html;
                if( $item->reserve=="non reservé" ){
                    $suprItem =ControleurUrl::urlId('reserve_item', $item->id);
                    $contenu =$contenu.<<<html
                    <td>
                    <form id="reserveritem" method="post" action="$suprItem"><button type="submit" name="valid" >reserver</button></form>
                    </td>
html;
                }
                else{
                    if($item->email==$_SESSION['email']){
                        $suprItem =ControleurUrl::urlId('dereserve_item', $item->id);
                        $contenu =$contenu.<<<html
                    <td>
                    <form id="dereserveritem" method="post" action="$suprItem"><button type="submit" name="valid" >dereserver</button></form>
                    </td>
html;
                    }
                    else{
                $contenu =$contenu.<<<html
                    <td>
                    </td>
html;
                    }
                }
            }
            $contenu=$contenu.<<<html
</tr>
html;
            
        }
        $vue=new VueHtml($contenu, VueHtml::$ARTICLE);
        $html = $vue->render();
        return $html;
    }
}

