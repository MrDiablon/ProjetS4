<?php
require_once 'autoload.include.php';


$web=new WebPage();
$web->setTitle("recupFormPostulAnnon");
$id_postulant=null;
$id_annonce=null;
$pourquoi=null;
$remu=null;



//$lib=$_POST['competence'];
//$niv=$_POST['detailscompetence'];



  if (isset($_POST['id_postulant'])){
	$id_postulant=$_POST['id_postulant'];
  }
  if (isset($_POST['id_annonce'])){
	$id_annonce=$_POST['id_annonce'];
  }
  if (isset($_POST['pourquoi'])){
	$pourquoi=$_POST['pourquoi']; 
  }
  if (isset($_POST['remuneration'])){
	$remu=$_POST['remuneration'];
  }
$ann = Annonce::CreateFromID($id_annonce);
$titre = $ann->getTitre();
$postulant = Particulier::createParticulierById($id_postulant);
$nom_postulant = $postulant ->getNom();
$prenom_postulant = $postulant ->getPrenom();
$mail_postulant= $postulant->getMail();
  
$annonce=Annonce::addPostulation($id_annonce,$id_postulant,$pourquoi,$remu);
$html =<<<HTML

<p>Votre Postulation pour l'annonce {$titre} à bien été enregistré et est soumit a la validation de {$prenom_postulant} {$nom_postulant}, un mail a l'adresse {$mail_postulant} vous sera adresse si vous etes retenu</p>
HTML;



$web ->appendContent($html);
echo $web->toHTML();








