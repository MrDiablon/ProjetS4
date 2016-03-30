<?php

require_once 'autoload.include.php' ;

/*
if (!User::isConnected()) {
    $web = new WebPage('Connexion') ;
    $html = <<<HTML
    <p class="bg-warning">Veuillez vous connecter pour accèder à cette page</p>
HTML;
    $html .= User::loginForm('connexion.php');
    $web->appendContent($html);
    echo $web->toHTML() ;
    die() ;
}
*/


/*
$id_annonceur =null;
//$id_travailleur =null;
if (!isset($_GET['ida'])){
	$id_annonceur=$_GET['idt'];
	$part = particulier::createParticulierById($id_annonceur);
}
if(!isset($_GET['idt'])){
	$id_annonceur=$_GET['ida'];
	$part = particulier::createParticulierById($id_annonceur);
}
*/
//var_dump($id_annonceur);
//var_dump($id_travailleur);

$part = particulier::createParticulierById(2);
 
$html =<<<HTML
	<table class="table table-striped">
		<tr>
				<th height="60" colspan=2>Carte de visite</th>
		</tr>
HTML;



$image = $part->getImage();

$nom = strtoupper($part->getNom());

$prenom = ucwords($part->getPrenom());

$adresse = $part->getAdresse();

$ville_id = $part->getVille_id();
$ville = $part->getVille();


$depart_id = $part->getDepartement_id();

$depart_nom = $part->getDepartementNom();


$dateNaiss = $part->getDate_Naissance();



$situatPro = $part->getSituation_Professionnelle();

$tel = $part->getNum_Tel();

$mail = $part->getMail();

$note = $part->getNote_moyenne();


// On affiche les informations
$html.="<tr>
			<td align='center' width='80' height='80'>
				<img src='photo.php?id=2' width='70px' height='70px'>
			</td>
			<td align='center'> {$nom} {$prenom} </td>
			
		</tr>
		
		<tr>
			<td align='center' width='20%'> Adresse : </td>
			<td align='center'>{$adresse} à {$ville} ({$depart_nom} {$depart_id}) </td>
		</tr>

		<tr>
			<td align='center' width='20%'>Date de naissance : </td>
			<td align='center'>{$dateNaiss}</td>
		</tr>

		<tr>
			<td align='center' width='20%'> Situation pro : </td>
			<td align='center'>{$situatPro}</td>
		</tr>

		<tr>
			<td align='center' width='20%'> Téléphone : </td>
			<td align='center'>{$tel}</td>
		</tr>

		<tr>
			
			<td align='center' width='20%'> Mail :</td>
			<td align='center'> {$mail}</td>
		</tr>




		<tr>
			<td align='center' width='20%'>Note moyenne :</td>
			
			<td><div align='center'>";

for($i=0 ; $i<$note ; $i++){
	$html.="<span class='glyphicon glyphicon-star' ></span>";
}

$html.="</div></td>
		</tr>
		</table>";


//Lister les compétences de l'utilisateur
$html.="<table class='table table-striped'>
			<tr>
				<th height='60' colspan=2>Liste des compétences</th>
			</tr>";

/*
$competences = $part->accederCompetences();
var_dump($competences);
*/

/*
foreach($competence as $COMPETENCE){
	$libelle = $COMPETENCE->getLibelle();
	$niveau = $COMPETENCE->getNiveau();
	
	$html.="<tr>
			<tr height=50>
			<td width=100 align='center'>{$libelle}</td>
			<td width=80 align='center'>{$niveau}</td>
			</tr>";
}
*/


//Lister les annonces demandées et réalisées par l'utilisateur




$web = new WebPage('Carte de visite') ;
$web->appendCssUrl("bootstrap/css/bootstrap.min.css");
$web->appendCssUrl("bootstrap/css/style.css");

$web->appendContent($html) ;

echo $web->toHTML() ;