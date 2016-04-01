<?php
require_once 'autoload.include.php';
require_once 'tosql.function.php';

$web=new WebPage();
$web->setTitle("recupForm");
$lib=null;
$niv=null;
$titre=null;
$descri=null;
$date=null;
$remu=null;
$competence = null;

//$lib=$_POST['competence'];
//$niv=$_POST['detailscompetence'];



  if (isset($_POST['competence'])){
	$lib=$_POST['competence'];
  }

  if (isset($_POST['detailscompetence'])){
	$niv=$_POST['detailscompetence']; 
  }
  if (isset($_POST['titre'])){
	$titre=$_POST['titre'];
  }
  if (isset($_POST['description'])){
	$descri=$_POST['description'];
  }
  if (isset($_POST['date'])){
	$date=tosql($_POST['date']);
	
  }
  if (isset($_POST['remuneration'])){
	$remu=$_POST['remuneration'];
  }

  $competence = Competence::createFromID(Competence::getIdbyLibelle($lib));
  $competence->setID(intval($competence->getID()));

  var_dump($competence);
 
//Competence::addCompetence($lib,$niv);
Annonce::addAnnonce($titre,$descri,$date,$remu,$competence);
//var_dump($date);
$html =<<<HTML
<!--<p>La compétence {$lib} ainsi que son niveau {$niv} ont bien été ajoutés</p>-->
{$titre}
{$descri}
{$date}
{$remu}
{$competence->getLibelle()}
HTML;



$web ->appendContent($html);
echo $web->toHTML();








