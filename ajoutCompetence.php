<?php

require_once 'autoload.include.php';

$competences = $_POST['data'];
$user = Utilisateur::createFromSession();
foreach ($competences as $competence) {
	$user->addCompetence(intval($competence['id_Competence']));
}

/*
//Débogage
$competence = $_GET['id'];
$user = Utilisateur::createFromSession();
var_dump($competence);
$user->addCompetence(intval($competence['id_competence']));*/