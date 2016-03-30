<?php

require_once 'class/particulier.class.php';

if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
	$villes = Particulier::getListVilleHtmlByDepartement($_GET['id']);
//var_dump($_GET['id']);
	echo json_encode($villes,JSON_PRETTY_PRINT);
}