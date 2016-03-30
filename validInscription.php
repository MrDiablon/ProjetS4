<?php

require_once 'class/particulier.class.php';
require_once 'tosql.function.php';

if(isset($_POST['inscription'])){
	$tab = $_POST;
var_dump($_FILES);
var_dump($_POST);
	$params = array();
	//var_dump(count($_POST));
	$tab['date_Naissance'] = toSQL($tab['date_Naissance']);
	while ($t = current($tab)) {
		if(is_string($t)){
			$tab[key($tab)] = htmlspecialchars($t);
		}
		if(key($tab) != "mdp2" && key($tab) != "MAX_FILE_SIZE"){
			$params[key($tab)] = $t;
		}
		next($tab);
	}
//var_dump($params);
	//$user = Particulier::createParticulier($params);
}