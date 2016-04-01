<?php
require_once 'autoload.include.php';

//"id_postulant":$id_postulant,"id_annonce":$id_annonce

if(isset($_POST)){
  $id_postulant = $_POST['id_postulant'];
  $id_annonce = $_POST['id_annonce'];
  
  Annonce::setEtatAccepter(true,$id_annonce);
  Annonce::deleteNotAccept($id_postulant,$id_annonce);
  $annonce = Annonce::CreateFromID($id_annonce);
  $annonce->setIdTravailleur($id_postulant);
}



