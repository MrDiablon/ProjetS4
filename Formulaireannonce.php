<?php
require_once 'autoload.include.php';



$web=new WebPage();
$web->setTitle("Formulaire Annonce");
$web->appendJsUrl("//code.jquery.com/jquery-1.10.2.js");
$web->appendJsUrl("//code.jquery.com/ui/1.11.4/jquery-ui.js");
$web->appendJs(<<<JS
  $(function() {
    $( "#datepicker" ).datepicker();
  });
JS
);
 $web->appendCssUrl("//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css");
 $competences = Competence::getAllInstances();
 $lib  = $competences[0]->getLibelle();
 $lib2 = $competences[4]->getLibelle();
 $lib3 = $competences[8]->getLibelle();

$html =<<<HTML
<meta charset="utf-8">
<form name="Formulaire" method="post" action="accueilinfo.php" id="annonceForm">
        Titre de l'annonce :                 <input type="text" name="titre"/> <br/>
            Entrez votre description :             <input type="text" name="description"/> <br/>
        Entrez votre date  :                 <input type="text" id="datepicker" name="date" /><br/>
        Entrez votre remuneration propose :         <input type="intval" name="remuneration"/> <br/>
        Selectionnez la competence <select name="competence" id="comp" form ="annonceForm">
        											<option id="comp" name="competence" value="Plomberie">$lib</option>
        											<option id="comp" name="competence" value="Electricite">$lib2</option>
        											<option id="comp" name="competence" value="Menage">$lib3</option>
        							</select>
                                <input type="submit" name="valider" value="Envoyer"/>
    </div>
</form>
HTML;


$web ->appendContent($html);
echo $web->toHTML();