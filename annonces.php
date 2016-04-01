<?php
require_once 'autoload.include.php';

$web=new WebPage();
$web->appendCssUrl("bootstrap/css/bootstrap.min.css");
$web->appendCssUrl("bootstrap/css/style.css");
$web->setTitle("Page avec la liste des annonces");
$annonce= Annonce::getAll();


$html =<<<HTML
	<table class="table table-striped">
		<tr>
			<th colspan=3>Annonces Disponible</th>
		</tr>
		<tr>
			<th>Titre de l'annonce</th>
			<!--<th>Description de l'annonce</th>-->
			<th>Date de l'annonce</th>
			<th>Remuneration de l'annonce</th>
			<th>Type de competence demandée</th>
		</tr>
HTML;




foreach($annonce as $ANNONCE){
	$titre = $ANNONCE->getTitre();
	$descri = $ANNONCE->getDescription();
	$date = $ANNONCE->getDate();
	$remu = $ANNONCE->getRemuneration();
	$id_annonce = $ANNONCE->getIdAnnonce();
	$id_annonceur = $ANNONCE->getIdAnnonceur();
	$libCompetence = Competence::getLibelleByIdAnnonce($ANNONCE->getIdAnnonce());
	
     
	$html.="<tr height=50 onclick=\"window.open('detailsannonce.php?id={$id_annonce}')\">
			<td width=100 align='left' >{$titre}</td>
			<!--<td width=100 align='left'>{$descri}</td>-->
			<td width=100 align='left'>{$date}</td>
			<td width=100 align='left'>{$remu} €</td>
			<td width=100 align='left'>{$libCompetence['libelle']}</td>
			
			
		</tr>";
}

$html .= <<<HTML
	</table>
HTML;

$web ->appendContent($html);
echo $web->toHTML();
