<?php
require_once 'autoload.include.php';

$recherche = isset($_GET['r']) ? $_GET['r'] : null;

$annonce= Annonce::recherche($recherche);

$web = new WebPage("Recherche");

$html = "";
$count = count($annonce);
if($count < 1) {
	$html .= "<h2>Aucune annonce ne correspond à votre recherche</h2>";
}
else {
	$html .= <<<HTML
		<table class="table table-striped">
			<tr>
				<th colspan=3>{$count} annonces correspondent à votre recherche</th>
			</tr>
			<tr>
				<th>Titre de l'annonce</th>
				<!--<th>Description de l'annonce</th>-->
				<th>Date de l'annonce</th>
				<th>Remuneration de l'annonce</th>
			</tr>
HTML;
	foreach($annonce as $ANNONCE){
		$titre = $ANNONCE->getTitre();
		$descri = $ANNONCE->getDescription();
		$date = $ANNONCE->getDate();
		$remu = $ANNONCE->getRemuneration();
		$id_annonce = $ANNONCE->getIdAnnonce();
		$id_annonceur = $ANNONCE->getIdAnnonceur();

		$html.= <<<HTML
				<a href="detailsannonce.php?id={$id_annonce}"><tr height=50 onclick="location.href='detailsannonce.php?id={$id_annonce}'">
				<td width=100 align='left' >{$titre}</td>
				<!--<td width=100 align='left'>{$descri}</td>-->
				<td width=100 align='left'>{$date}</td>
				<td width=100 align='left'>{$remu} €</td>
			</tr>
HTML;

}

$html .= <<<HTML
	</table>
HTML;
}

$web->appendContent($html);

echo $web->toHTML();
