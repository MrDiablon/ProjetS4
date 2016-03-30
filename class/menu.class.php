<?php

//require_once 'user.class.php';
require_once 'autoload.include.php';

class Menu {

    private $html = "" ;


    public function __construct() {
		$link = "$_SERVER[REQUEST_URI]";
		$items = "";
		$start = '
    <div class="navbar navbar-inverse ">
  		<div class="container">
  			<a href="index.php" class="navbar-brand"> Services </a>
  				<button class="navbar-toggle" data-toggle = "collapse" data-target =".navHeaderCollapse">
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  				</button>
  				<div class="collapse navbar-collapse navHeaderCollapse">
					<ul class="nav navbar-nav navbar-right">';
		/*if(substr($link, 0, 6) == '/index' || $link == '/')
			$items .= '<li class="active">';
		else
			$items .= '<li>';
		$items .= '<a href="index.php">Accueil</a> </li>';*/
		//$items .= '<li><a href="index.php" data-toggle="modal" data-target=".bs-example-modal-sm">Connexion</a> </li>';
        $form = User::loginForm('connexion.php');
        if (!User::isConnected()) {
        $connexion = <<<HTML
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
              Connexion
            </button>

            <a href='inscription.php'>
            <button type="button" class="btn btn-primary btn-lg">
              Inscription
            </button>
            </a>



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
        else {
            $user = User::createFromSession() ;
            $connexion = <<<HTML
            <li><a href="Formulaireannonce.php">Créer une annonce</a></li>
            <li><a href="carteVisite.php?ida={$user->id()}" title="Afficher mon profil">{$user->prenomNom()}</a></li>
            <li>
HTML;
            $connexion .= User::logoutForm('Déconnexion', 'index.php') ;
            $connexion .= "</li>";
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
	$this->appendHTML($items) ;
	$this->appendHTML($connexion) ;
	$this->appendHTML($end);
    }

    public function appendHTML($content) {
        $this->html .= $content ;
    }

    public function getHTML() {
		return $this->html;
	}

}
