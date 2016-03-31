<?php

require_once 'autoload.include.php';

if(isset($_GET['id']) && is_numeric($_GET['id'])){
	$id=$_GET['id'];
}else{
	$id=1;
}
$competences = Competence::getCompetenceByParents($id);

echo json_encode($competences,JSON_PRETTY_PRINT); 