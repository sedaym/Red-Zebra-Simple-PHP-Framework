<?php if ( ! defined('BASE_PATH')) exit('Access IS NOT allowed');

class App{
	
	var $uri;
	var $model;
	var $lib;
	var $db = NULL;

	function __construct($uri){
		
		$this->uri = $uri;
		
	}

	function loadController($class){
		
		$file = "app/controller/".$this->uri['controller'].".php";

		if(!file_exists($file)){
				
			require('errors/404.html');
			die();
			
		}

		require_once($file);

		$controller = new $class();

		if(method_exists($controller, $this->uri['method'])){
			
			call_user_func_array(array($controller,$this->uri['method']), $this->uri['params']);
			//$controller->{$this->uri['method']}($this->uri['params']);
			
		}else{
			
			$controller->index();
			
		}
		
	}

	function loadView($view,$vars=""){
	
		if(is_array($vars) && count($vars) > 0)	extract($vars, EXTR_PREFIX_SAME, "wddx");
		
		require_once('view/'.$view.'.php');
		
	}

	function loadModel($model){
		
		require_once('model/'.$model.'.php');
		
		$this->model = new $model;
		
		return $this->model;
		
	}
	
	function loadLib($lib){
		
		require_once('lib/'.$lib.'.php');
		
		$this->lib = new $lib;
		
		return $this->lib;
		
	}
	
	function loadDb(){
		
		if($this->db == NULL){
		
			require_once('native_libraries/db.class.php');	
			$this->db = new DB(DB_DATABASE,DB_SERVER,DB_USER,DB_PASS);
		
		}
	
		return $this->db;
					
	}
	
	function getUrlSegment($segment){
		
		$url = $_SERVER['REQUEST_URI'];
		$url = str_replace(APP_PATH,"",$url);
		
		$url_segments = preg_split('[\\/]', $url, -1, PREG_SPLIT_NO_EMPTY);
		
		return $url_segments[$segment-1];
				
	}
	
}//End App class.