<?php

require_once 'tosql.function.php';
require_once 'autoload.include.php';

$p = new webPage('Inscription');
$p->appendJsUrl("js/sha1.js");
$p->appendJsUrl("js/cryptagemdp.js");
$p->appendJsUrl("js/request.js");
//var_dump($_POST);
$html = <<<HTML
	<form method="post" action="#" enctype="multipart/form-data" onSubmit="crypterMdp(this)">
		<label for="nom">Nom</label>
		<input type="text" name="nom" placeholder="Votre nom" required><br>
		<label for="prenom">Prénom</label>
		<input type="text" name="prenom" placeholder="Votre prénom" required><br>
		<label for="departement">departement</label>
		<select id="departement" onchange="getVille(this)">
			<option value="0">Autre</option>
HTML;
//Departement
$departement = Particulier::getListDepartement();
foreach ($departement as $dep) {
	$html.=<<<HTML
		<option value="{$dep['id']}">{$dep['departement']}
HTML;
}
//Ville
$html.=<<<HTML
		</select><br>
		<label for="ville_id" id="villeLabel" style="display:none">Ville</label>
		<select name="ville_id" id="ville_id"  style="display:none">
HTML;
/*$villes = Particulier::getListVilleHtml();
foreach ($villes as $ville) {
	$html.=<<<HTML
		<option value="{$ville['id']}">{$ville['ville']}
HTML;
}*/
$html.=<<<HTML
			<option value ="">
		</select><br>
		<label for="adresse">Adresse</label>
		<input type="text" name="adresse" placeholder="Votre Adresse" required><br>
		<label for="date_Naissance">Date de naissance</label>
		<input type="date" name="date_Naissance" placeholder="Votre date de naissance" required><br>
		<label for="situation_Professionnelle">Situation professionnelle</label>
		<input type="text" name="situation_Professionnelle" placeholder="Votre situation professionnelle" required><br>
		<label for="num_Tel">Numero de télèphone</label>
		<input type="tel" name="num_Tel" placeholder="Votre numero de télèphone" required><br>
		<label for="mail">Mail</label>
		<input type="mail" name="mail" placeholder="Votre mail" required><br>
		<label for="mdp">Mots de passe</label>
		<input type="password" id="mdp" name="mdp" pattern="^[A-Za-z0-9]{6,25}$" onkeyup="verifPass(this)" required><br>
		<label for="mdp">Ressaisire le mots de passe</label>
		<input type="password" name="mdp2" id="mdp2" pattern="^[A-Za-z0-9]{6,25}$" onkeyup="verifPass(this)" required><br>
		<label for="image">Image</label>
		<input type="hidden" name="MAX_FILE_SIZE" value="250000" >
		<input type="file" name="image"><br>
		<input type="submit" name="inscription">
	</form>
HTML;

if(isset($_POST['inscription'])){
	$tab = $_POST;
//var_dump($_FILES);
//var_dump($_POST);
	$params = array();
	//var_dump(count($_POST));
	$tab['date_Naissance'] = toSQL($tab['date_Naissance']);
	//recuperation des donée necessaire a la creation
	while ($t = current($tab)) {
		if(is_string($t)){
			$tab[key($tab)] = htmlspecialchars($t);
		}
		if(key($tab) != "mdp2" && key($tab) != "MAX_FILE_SIZE"){
			$params[key($tab)] = $t;
		}
		next($tab);
	}

	//verification de l'image
	$tabExt = array('png','jpg','jpeg','PNG','JPG','JPEG'); // Extensions autorisees
	$message = "";

	if(isset($_FILES['image'])){
		$image = $_FILES['image'];
		if(!empty($image['name'])){
			$extension = pathinfo($image['name'], PATHINFO_EXTENSION);
			if(in_array(strtolower($extension),$tabExt)){
				if($image['error'] == 0){
//var_dump( file_get_contents($image['tmp_name']) );
					$params['image'] = file_get_contents($image['tmp_name']);
					$message = "upload reussie";
					
				}else{
					$message .= "|Une erreur lié à l'image est survenue !";
				}
			}else{
				$message .= "|l'extension du ficihier est incorrecte";
			}
		}
	}
//var_dump($params);
	$user = Particulier::createParticulier($params);
	if($message != "upload reussie" && $message != ""){
		echo "<script>alert($message)</script>"; 
	}else{
		echo "<script>alert(\"inscription reussie un mail de confirmation as été envoyer\")</script>";
		echo '<meta http-equiv="refresh" content="0; URL=index.php">';
	}
}

$p->appendContent($html);
echo $p->toHtml();