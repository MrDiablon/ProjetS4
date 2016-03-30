<?php

require_once 'autoload.include.php' ;

$web = new WebPage("Services");
$web->appendCssUrl("bootstrap/css/bootstrap.min.css");
$web->appendCssUrl("bootstrap/css/style.css");
//$web-> appendToHead("<meta name='viewport' content='width=device-width, initial-scale=1.0'>");

User::logoutIfRequested();


$html =<<<HTML
  <a href="annonces.php"><button type="button" class="btn btn-default">Voir toutes les annonces</button></a>
HTML;

$web->appendContent($html);


echo $web->toHTML();
