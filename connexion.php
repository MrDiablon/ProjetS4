<?php
// require_once 'class/webpage.class.php' ;
// require_once 'class/user.class.php' ;
require_once 'autoload.include.php' ;

$p = new WebPage('Connexion') ;

try {
    // Tentative de connexion
    $user = Utilisateur::createFromAuth($_REQUEST) ;
    $user->saveIntoSession() ;
    
header("Location: http://{$_SERVER['SERVER_NAME']}/".dirname($_SERVER['PHP_SELF'])) ;
    die();

}

catch (AuthenticationException $e) {
    // Récuperation de l'exception si connexion échouée
    $p->appendContent('<p class="bg-warning">');
    $p->appendContent($e->getMessage()) ;
    $p->appendContent("</p>");
    $p->appendContent(Utilisateur::loginForm('connexion.php'));
}
catch (Exception $e) {
    $p->appendContent("Un problème est survenu&nbsp;: {$e->getMessage()}") ;
    $p->appendContent(Utilisateur::loginForm('connexion.php'));
}

// Envoi du code HTML au navigateur du client
echo $p->toHTML() ;
