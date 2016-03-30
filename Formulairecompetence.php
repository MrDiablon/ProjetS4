<?php
require_once 'webpage.class.php';
require_once 'competence.class.php';

$web=new WebPage();
$web->setTitle("Formulaire Competence");
$competence= competence::getCompetenceByNiveau(0);
$html =<<<HTML
<form name="Formulaire" method="post" action="accueilinfo.class.php">
	        Selectionner votre competence : 			<SELECT name="competence" size="1"><br/>
HTML;
foreach($competence as $COMPETENCE){
	$libelle = $COMPETENCE->getLibelle();
	$niveau = $COMPETENCE->getNiveau();
	$html.="<OPTION value=\"{$niveau}\">{$libelle}";
}
$competence= competence::getCompetenceByNiveau(1);
$html .=<<<HTML
	        </SELECT><br/>
		Selectionner la sous competence sur votre competence   : <SELECT name="detailscompetence" size="1"><br/>
HTML;
foreach($competence as $COMPETENCE){
	$libelle = $COMPETENCE->getLibelle();
	$niveau = $COMPETENCE->getNiveau();
	$html.="<OPTION value=\"{$niveau}\">{$libelle}";
	
}
$html .=<<<HTML
			</SELECT><br/>
			
			
			<input type="submit" name="valider" value="Envoyer"/>
	</div>			
</form>



HTML;


$web ->appendContent($html);
echo $web->toHTML();
