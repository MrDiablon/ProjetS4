<?php
require_once 'webpage.class.php';
require_once 'competence.class.php';

$web=new WebPage();
$web->setTitle("Page avec la liste des competence");

$competence= competence::getAll();

$html=<<<HTML
	<table border="2">
		<tr>
			<th colspan=2>Competences Disponible</th>
		</tr>
		<tr>
			<th>Libelle de la competence</th>
			<th>Niveau de la competence</th>
		</tr>
HTML;

foreach($competence as $COMPETENCE){
	$libelle = $COMPETENCE->getLibelle();
	$niveau = $COMPETENCE->getNiveau();
	
	$html.="<tr>
			<tr height=50>
			<td width=100 align='center'>{$libelle}</td>
			<td width=80 align='center'>{$niveau}</td>
			</tr>";
}





$web ->appendContent($html);
echo $web->toHTML();
