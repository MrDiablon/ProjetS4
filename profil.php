<?php
//require_once('user.class.php') ;
//require_once('webpage.class.php') ;
require_once 'autoload.include.php' ;

if (!User::isConnected()) {
    $web = new WebPage('Connexion') ;
    $html = <<<HTML
    <p class="bg-warning">Veuillez vous connecter pour accèder à cette page</p>
HTML;
    $html .= User::loginForm('connexion.php');
    $web->appendContent($html);
    echo $web->toHTML() ;
    die() ;
}

$web = new WebPage('Profil') ;
$user = Utilisateurr::createFromSession() ;
$web->appendContent(<<<HTML
        {$user->profile()}
HTML
) ;

echo $web->toHTML() ;
