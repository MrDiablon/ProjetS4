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



//$id_annonceur =null;
//$id_travailleur =null;

/*
if (!isset($_GET['ida'])){
	$id_annonceur=$_GET['idt'];
	$part = particulier::createParticulierById($id_annonceur);
}
if(!isset($_GET['idt'])){
	$id_annonceur=$_GET['ida'];
	$part = particulier::createParticulierById($id_annonceur);
}
else{
	$user = Utilisateur::createFromSession() ;
	$part = particulier::createParticulierById($user->getId());	
}*/

//var_dump($id_annonceur);
//var_dump($id_travailleur);

if (!isset($_GET['id'])){
	$id=$_GET['id'];
	$part = particulier::createParticulierById($id);
}
else{
	$user = utilisateur::createFromSession() ;
	$id_part = $user->getId();
	$part = particulier::createParticulierById($user->getId());

}
 
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
				<img src='photo.php?id=1', width='70px' height='70px'>
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
				<th height='50' colspan=2>Liste des compétences</th>
			</tr></table>";

$competences = $part->accederCompetences();

$id=null;
$html.="<div id='liste'>";
foreach($competences as $COMPETENCE){
	$id = $COMPETENCE->getId();
	$niveau = $COMPETENCE->getNiveau();
	$competences = competence::getCompetenceByParents($COMPETENCE->getId());
	//var_dump($competences);
	if($niveau == 0){
		$lib = $COMPETENCE->getLibelle();
		$html.="<div id='lib'> {$lib} </div>
					<div id='num'>
						<div id='buttons'>
							<button type='button' id='add' class='glyphicon glyphicon-plus' onclick='modif'>
						</div><hr>";
	} 	
	else{
		$libelle = $COMPETENCE->getLibelle();
		$html.= "		<div id='souslib'>
								<div>
								<span class='glyphicon glyphicon-arrow-right'></span>
									{$libelle}
								<button type='button' id='remove' class='glyphicon glyphicon-minus' onclick='supprimer'>
								</div>
						</div><hr>";

		
	}
}
$html.="			</div>
				</div>";



$html.="</div>
		
		<div id='ajouter'>
		<label>Ajoutez vos compétences :</label>
			<button id='valider' type='button' name='Ajouter une compétence' class='glyphicon glyphicon-pencil' style='width:100px' onclick='cacher()'>
		</div>

		<script>
      		function cacher(){
        		$('div#form').css('display','inline-block');
        		$('#button').css('display','none');
      		}

       </script>

       <script>
       	function supprimer(){
      			$.ajax({
      				type:'GET',
      				url:'supprimerCompetence.php',
      				data:{'id_Competence': $id},
      				success: function(data){
         					alert('La compétence a été retirée);
         					window.location.reload('carteVisite.php');
         					$('#remove').css('display','none');
      						});
      		}
       </script>";

//Lister les annonces demandées et réalisées par l'utilisateur
$html.="<div id='form' style=\"display:none\">";

		include('formSelectCompetence.php');


				
		$html.= "</div>";


$web = new WebPage('Carte de visite') ;
$web->appendJsUrl("js/competence.js");
$web->appendCssUrl("bootstrap/css/bootstrap.min.css");
$web->appendCssUrl("bootstrap/css/style.css");
$web->appendCss(" #liste{
 					border-style:double;
 					border-color:black;
					margin-bottom:50px;
					margin-top:30px;
					text-align:center;
				}

				#buttons{
					display:inline-block;
					margin-left:10px;
				}

				#ajouter{
					display:inline;
					margin-left:40%;
					padding-bottom:20%;
				}

				#remove{
					margin-left:3%;
				}

				#add{
					margin-top:5%;
				}

				#lib{
					font-weight:bold
				}");


$web->appendContent($html) ;

echo $web->toHTML() ;