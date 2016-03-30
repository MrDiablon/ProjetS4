<?php

function toSQL($date) {
$jour = htmlspecialchars(substr($date, 0, 2));
$personnes = htmlspecialchars(substr($date, 3, 2));
$annee = htmlspecialchars(substr($date, -4));
$toSQL = $annee .'-'. $personnes .'-'. $jour;
return $toSQL;
}

// convertit les dates SQL aaaa-mm-jj en jj/mm/aaaa en passant par le timestamp
function toString($date) {
	$d = explode('-', $date);
	$retour = $d[2].'/'.$d[1].'/'.$d[0];
	return $retour;
}