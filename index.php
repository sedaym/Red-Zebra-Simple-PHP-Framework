<?php
//Includes
include_once('variables.php');
include_once('config.php');

//Take the initial PATH.
$url = $_SERVER['REQUEST_URI'];
$url = str_replace(APP_PATH,"",$url);

//creates an array from the rest of the URL
$array_tmp_uri = preg_split('[\\/]', $url, -1, PREG_SPLIT_NO_EMPTY);

//Get Number of Params
$elements = count($array_tmp_uri);
$params = $elements-2;

//Here, we will define what is what in the URL
if($elements > 0){
	
	$array_uri['controller']	= $array_tmp_uri[0]; //Controller (Class)
	$array_uri['method']		= $array_tmp_uri[1]; //Method
	
	if($params > 0){
		
		//Rid of Controller and Method
		array_shift($array_tmp_uri);
		array_shift($array_tmp_uri);
		
		//Assign Params
		for($i = 0; $i < $params; $i++){
			
			$array_uri['params'][$i] = $array_tmp_uri[$i];
			
		}
		
	}

}else{
	
	$array_uri['controller'] = DEFAULT_CONTROLLER; //Controller (Class)
	
}

//Load our base API
require_once("app/base.php");

//loads our controller
$application = new App($array_uri);
$application->loadController($array_uri['controller']);