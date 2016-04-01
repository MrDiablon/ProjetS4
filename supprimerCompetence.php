<?php
require_once('autoload.include.php');


if(isset($_GET)){
  $id_Comp = $_GET['id'];
  $user = Utilisateur::createFromSession() ;
  $part = Particulier::createParticulierById($user->getId());
 
  $competence = Competence::CreateFromID($id_Comp);
  $part->deleteCompetence($id_Comp);
}