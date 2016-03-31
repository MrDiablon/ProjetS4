<?php

require_once 'autoload.include.php';

$p = new webPage('Competence');
$p->appendJsUrl("js/competence.js");
//$p->appendJsUrl("js/request.js");
$competences = competence::getCompetenceByNiveau(0);
$html = <<<HTML
	<div style="float:left">
		<label for="competence">Selection une categorie</label>
		<select id="competence" name="Competence" onchange="getSousComp(this)">
			<option value="0">Autre
HTML;

//ajout des competence
foreach ($competences as $competence) {
	//var_dump($competences);
	$html.=<<<HTML
			<option value="{$competence->getId()}">{$competence->getLibelle()}
HTML;
}


$html.=<<<HTML
		</select><br>
		<label id="sousCompetenceLabel" for="sousCompetence" style="display:none">Selection une sous categorie</label>
		<select id="sousCompetence" name="sousCompetence" style="display:none">
		</select>

		<input type="button" id="btnAjoutCompetence" value="Ajouter La competence" onclick="ajoutCompt()" style="display:none">
	</div>
	<div>
		<select name="comptSelect" multiple>
		</select>
	</div>
	<input type="submit" value="Valider">
HTML;

$p->appendContent($html);
echo $p->toHTML();