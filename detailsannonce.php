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

$particulier= Particulier::createParticulierById($id_annonceur);
$travailleur= Particulier::createParticulierById($id_travailleur);

$nom_particulier = $particulier->getNom();
$prenom_particulier = $particulier->getPrenom();
$nom_travailleur = $travailleur ->getNom();
$prenom_travailleur = $travailleur ->getPrenom();

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



$web ->appendContent($html);
echo $web->toHTML();
