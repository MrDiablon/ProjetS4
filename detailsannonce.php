<?php
require_once 'autoload.include.php';

$web=new WebPage();
$web->appendCssUrl("bootstrap/css/bootstrap.min.css");
$web->appendCssUrl("bootstrap/css/style.css");
$web->setTitle("Page avec le detail de l'annonce");
$id_annonce;
 if (isset($_GET['id'])){
	$id_annonce=$_GET['id'];
  }

$annonce = Annonce::CreateFromID($id_annonce);
$titre = $annonce->getTitre();
$descri = $annonce->getDescription();
$date = $annonce->getDate();
$remu = $annonce->getRemuneration();
$note= $annonce->getNote();
$com = $annonce ->getCommentaire();
$id_annonceur = $annonce ->getIdAnnonceur();

$id_travailleur = $annonce ->getIdTravailleur();

if($id_travailleur != null){
	$travailleur = Particulier::createParticulierById($id_travailleur);
	$nom_travailleur = $travailleur ->getNom();
	$prenom_travailleur = $travailleur ->getPrenom();
}
else{
	$nom_travailleur = "";
	$prenom_travailleur = "";	
}
$particulier= Particulier::createParticulierById($id_annonceur);
$nom_particulier = $particulier->getNom();
$prenom_particulier = $particulier->getPrenom();




$html =<<<HTML
	<table class="table table-striped">
		<tr height=50>
			<th colspan=2 >Detail de l'annonce</th>
		</tr>
		<tr>
		<tr height=50 width=0.5>
			<th  width=0.5>Titre de l'annonce</th><td>{$titre}</td>
		</tr>
		<tr height=50 width=0.5 onclick="window.open('carteVisite.php?ida={$id_annonceur}')">
			<th  width=0.5>Personne deposant l'annonce</th><td>{$prenom_particulier}  {$nom_particulier}</td>
		</tr>

		<tr height=50 width=0.5 onclick="window.open('carteVisite.php?idt={$id_travailleur}')">
			<th  width=0.5>Personne executant l'annonce</th><td >{$prenom_travailleur}  {$nom_travailleur}</td>
		</tr>
		<tr height=50 width=0.5>
			<th  width=0.5>Description de l'annonce</th><td>{$descri}</td>
		</tr>
		<tr height=50 width=0.5>
			<th  width=0.5>date de l'annonce</th><td>{$date}</td>
		</tr>
		<tr height=50 width=0.5>
			<th  width=0.5>Remuneration de l'annonce</th><td>{$remu} €</td>
		</tr>
		
HTML;
	if($note != null && $note != 0){
	    $html .=<<<HTML
		<tr height=50 width=0.5>
			<th  width=0.5>Note de l'annonce</th><td>{$note}</td>
		</tr>
	    
HTML;
	}
	if($com != null && $com != ""){
	    $html .=<<<HTML
		<tr height=50 width=0.5>
			<th  width=0.5>Commentaire de l'annonce</th><td>{$com}</td>
		</tr>
	    
HTML;
	}
		
		
$html .=<<<HTML
	</table>
HTML;




try {
    // Tentative de connexion
    $user = Utilisateur::createFromSession() ;


    if($user->getId()!=$id_annonceur){
       $html.=<<<HTML
        <input type="button" name="postuler" id="bouton" value="Postuler a cette annonce" style="width:200px" onclick="cacher()">
        <div id="form" style="display:none">
	  <form name="accepterAnnonce" method="post" action="recupFormPostuAnno.php" >
	    <input type="hidden" value = "{$user->getId()}"  name="id_postulant">
	    <input type="hidden" value = "{$id_annonce}"  name="id_annonce">
	    <label for="pourquoi">Dites a l'annonceur pourquoi il devrait vous choisir  :</label>        <textarea name="pourquoi"></textarea> <br/>
            <label for="remuneration"> Proposez une remuneration  :</label>                     <input type="intval" name="remuneration"/> <br/>
            <input type="submit" name="valider" value="Envoyer"/>      
          </form>
       </div>
       <script>
	  function cacher(){
	    $("div#form").css("display","block");
	    $("#bouton").css("display","none");
	  }
       </script>
HTML;
	}

    else {
    $postulant= Annonce::getAllPostulation();
      $html .=<<<HTML
      <table class="table table-striped">
		<tr>
			<th colspan=4>Postulation Disponible</th>
		</tr>
		<tr>
			<th>Nom du postulant</th>
			<th>Son texte pour vous convaincre</th>
			<th>Remuneration propose</th>
			<th></th>
		</tr>
HTML;




foreach($postulant as $postulants){
	$id_postulant = $postulants->getIdAnnonceur();
	$postulant = Particulier::createParticulierById($id_postulant);
	$nom_postulant = $postulant ->getNom();
	$prenom_postulant = $postulant ->getPrenom();
	$mail_postulant= $postulant->getMail();
	$descri = $postulants->getPourquoi();
	
	$remu = $postulants->getremuneration_Souhaite();
	
     
	$html.="<tr>
			<td width=100 align='left' >{$prenom_postulant}    {$nom_postulant}</td>
			<td width=100 align='left'>{$descri}</td>
			<td width=100 align='left'>{$remu}</td>
			<td width=100 align='left'> <input type='button' name='lien1' value='Accepter' onclick=''></td>
			
			
		</tr>";
}	


$html .= <<<HTML
<script>
	  function select(){
	    $("div#form").css("display","block");
	    $("#bouton").css("display","none");
	  }
       </script>

	</table>
HTML;
    
    }
} 

catch (AuthenticationException $e) {
    // Récuperation de l'exception si connexion échouée
    $web->appendContent("Échec d'authentification&nbsp;: {$e->getMessage()} Mauvais login/mot de passe") ;
}
catch (Exception $e) {
    $web->appendContent("Un problème est survenu&nbsp;: {$e->getMessage()} Veuillez vous connecter ! ");
    echo('<meta http-equiv="refresh" content="0; URL=connexion.php">');
}

//include('FormPostuleAnnonce.html');




$web ->appendContent($html);
echo $web->toHTML();
