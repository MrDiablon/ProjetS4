<?php
// require_once 'class/webpage.class.php' ;
// require_once 'class/user.class.php' ;
require_once 'autoload.include.php' ;

$p = new WebPage('Connexion') ;

try {
    // Tentative de connexion
    $user = User::createFromAuth($_REQUEST) ;
    $user->saveIntoSession() ;
    $p->appendContent(<<<HTML
<div>{$user->profile()}</div>
HTML
) ;
header("Location: http://{$_SERVER['SERVER_NAME']}/".dirname($_SERVER['PHP_SELF'])) ;
    die();

}

catch (AuthenticationException $e) {
    // Récuperation de l'exception si connexion échouée
    $p->appendContent('<p class="bg-warning">');
    $p->appendContent($e->getMessage()) ;
    $p->appendContent("</p>");
    $p->appendContent(User::loginForm('connexion.php'));
}
catch (Exception $e) {
    $p->appendContent("Un problème est survenu&nbsp;: {$e->getMessage()}") ;
    $p->appendContent(User::loginForm('connexion.php'));
}

// Envoi du code HTML au navigateur du client
echo $p->toHTML() ;
