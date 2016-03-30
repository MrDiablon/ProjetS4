<?php
require_once 'webpage.class.php';
require_once 'annonce.class.php';

$web=new WebPage();
$web->setTitle("Page avec la liste des annonces");
$annonce= Annonce::getAll();

$html =<<<HTML
	<table border="2">
		<tr>
			<th colspan=4>Annonces Disponible</th>
		</tr>
		<tr>
			<th>Titre de l'annonce</th>
			<th>Description de l'annonce</th>
			<th>Date de l'annonce</th>
			<th>Remuneration de l'annonce</th>
		</tr>
HTML;

foreach($annonce as $ANNONCE){
	$titre = $ANNONCE->getTitre();
	$descri = $ANNONCE->getDescription();
	$date = $ANNONCE->getDate();
	$remu = $ANNONCE->getRemuneration();
	
	$html.="<tr>
			<tr height=50>
			<td width=100 align='center'>{$titre}</td>
			<td width=80 align='center'>{$descri}</td>
			<td width=100 align='center'>{$date}</td>
			<td width=100 align='center'>{$remu}</td>
			</tr>";
}





$web ->appendContent($html);
echo $web->toHTML();
