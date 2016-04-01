<?php
require_once 'autoload.include.php';

$postulation= Annonce::getAllPostulation();
$id_postulant = $postulation->getIdAnnonceur();
$postulant = Particulier::createParticulierById($id_postulant);

$html =<<<HTML
	
HTML;


