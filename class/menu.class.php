<?php

//require_once 'user.class.php';
require_once 'autoload.include.php';

class Menu {

    private $html = "" ;


    public function __construct() {
		$link = "$_SERVER[REQUEST_URI]";
		$items = "";
		$start = <<<HTML
    <div class="navbar navbar-inverse ">
  		<div class="container">
  			<a href="index.php" class="navbar-brand"> Services </a>
  				<button class="navbar-toggle" data-toggle = "collapse" data-target =".navHeaderCollapse">
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  				</button>
  				<div class="collapse navbar-collapse navHeaderCollapse">
					<ul class="nav navbar-nav navbar-right">
HTML;

        $barreRecherche = <<<HTML
            <li id="barreRecherche">
            <form name="recherche" action="recherche.php" method="GET" class="input-group" aria-describedby="recherche">
              <input type="text" class="form-control" name="r"
HTML;
        /*if(substr($link, strlen($link)-14, strlen($link)) == '/recherche.php') {
        $recherche = isset($_GET['r']) ? $_GET['r'] : null;
        $barreRecherche .= <<<HTML
        value="{$recherche}"
HTML;
        }*/
        $barreRecherche .= <<<HTML
        placeholder="Rechercher une annonce" style="width: 400px;" required>
    <span class="input-group-btn" >
      <button type="submit" class="btn btn-default" id="recherche" value="Rechercher"><span class="glyphicon glyphicon-search" ></span></button>
              </span>
 </form>
        </li>
HTML;

        if (!Utilisateur::isConnected()) {
            $connexion = SELF::menuVisiteur();
        }
        else if (Utilisateur::isAdministrator()){
            $connexion = SELF::menuAdministrateur();
        }
        else {
            $connexion = SELF::menuParticulier();
        }

    $end = <<<HTML
                </ul>
            </div>
  		</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="content1">

HTML;

    $end .= <<<HTML
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    	<script src ="bootstrap/js/bootstrap.js"></script>
HTML;

    $this->appendHTML($start) ;
	$this->appendHTML($barreRecherche) ;
	$this->appendHTML($connexion) ;
	$this->appendHTML($end);
    }

    public function menuVisiteur() {
        $form = Utilisateur::loginFormSHA1('connexion.php');
        $visit = "";
        $link = "$_SERVER[REQUEST_URI]";
        if(substr($link, strlen($link)-14, strlen($link)) != '/connexion.php' && substr($link, strlen($link)-10, strlen($link)) != '/connexion') {
            $visit .= <<<HTML
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                  Connexion
                </button>

                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Connexion</h4>
                      </div>
                      <div class="modal-body">
                        {$form}
                      </div>
                      <!--<div class="modal-footer">
                      </div>-->
                    </div>
                  </div>
                </div>
HTML;
        }
        $visit .= <<<HTML
                <a href='inscription.php'>
                <button type="button" class="btn btn-primary btn-lg">
                  Inscription
                </button>
                </a>
HTML;
        return $visit;
    }

    public function menuParticulier() {
        try {
            $user = Utilisateur::createFromSession() ;
            $form = Utilisateur::logoutForm('Déconnexion', 'index.php') ;
            return <<<HTML
            <li><a href="Formulaireannonce.php">Créer une annonce</a></li>
            <li><a href="mesAnnonces.php" title="Afficher les annonces que j'ai publié">Mes annonces</a></li>
            <!--<li><a href="" title="Voir les avis que j'ai publié/reçu">Avis</a></li>-->
            <li><a href="carteVisite.php?ida={$user->getId()}" title="Afficher mon profil">{$user->prenomNom()}</a></li>
            <li>{$form}</li>
HTML;
        }
        catch (notInSessionException $e) {

        }
    }

    public function menuAdministrateur() {
        try {
            $user = Utilisateur::createFromSession() ;
            $form = Utilisateur::logoutForm('Déconnexion', 'index.php') ;
            return <<<HTML
            <li><a href="Formulaireannonce.php">Créer une annonce</a></li>
            <li><a href="" title="Afficher les annonces que j'ai publié">Mes annonces</a></li>
            <li><a href="" title="Voir les avis que j'ai publié/reçu">Avis</a></li>
            <li><a href="">Gérer les annonces</a></li>
            <li><a href="carteVisite.php?ida={$user->getId()}" title="Afficher mon profil">{$user->prenomNom()}</a></li>
            <li>{$form}</li>
HTML;
        }
        catch (notInSessionException $e) {

        }
    }

    public function appendHTML($content) {
        $this->html .= $content ;
    }

    public function getHTML() {
		return $this->html;
	}

}
