<?php

require_once 'autoload.include.php';
require_once 'myPDO.include.php' ;

try {
    if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
        throw new Exception("Paramètre manquant") ;
    }

    $photo = photo::createFromId($_GET['id']) ;
    //var_dump($photo);
    header('Content-Type: image/jpeg') ;
    echo $photo->getJPEG() ;
}
catch(Exception $e) {
    echo "Problème de chargement : {$e->getMessage()}" ;
}
