<?php if ( ! defined('BASE_PATH')) exit('Access IS NOT allowed');

class Welcome extends App{
	
	function __construct(){
		
	}
	
	function index(){
		
		$this->loadView('welcome');
		
	}
	
	function test($arg1,$arg2){

		//Testing Arguments (@URL)
		$data[] = 'URL argument 1: '.$arg1;
		$data[] = 'URL argument 2: '.$arg2;
		
		//Testing Libraries
		$test = $this->loadLib('test');
		$data[] = $test->test();
		$data[] = $test->test2();		
		
		//Testing Loading Models
		$model = $this->loadModel('test_model');
		$data['model_data']= $model->test_model();
		
		//Test Get URL Segments
		$data['segment1'] = $this->getUrlSegment(1);
		
		//Testing Loading Views
		$this->loadView('welcome',$data);
		
	}
	
}