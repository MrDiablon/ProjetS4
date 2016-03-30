<?php

/*
function __autoload($class_name){
  include 'class/'.$class_name.'.class.php';
}*/

spl_autoload_register(function ($class) {
	if(file_exists(strToLower($class) . '.class.php')){
		$fichier =  strToLower($class) . '.class.php';
	}else{
		$fichier = $class . '.class.php';
	}
    if(file_exists($fichier)){
      include $fichier;
    }
});
