<?php
include_once("model/page.php");
//include_once(SERVER_ROOT . '/admin/lib/authentication.php');
//include_once(SERVER_ROOT . '/admin/lib/log.php');

class com_home_Controller {
	
	public $model;
	
	public function __construct()  
    {  
  
    } 
	
	public function invoke($view,$task)
	{
		
		if($task)
		{
		
					
		}
		else
		{
		
			if($view=="home")
			{
				$this->showPage();
			}
								
		}
		
		
	}
	
	
	public function showPage()
	{	    
		$objPage = new page();
		//$stateLists = $objPage->getUserStates();
		include 'view/home.php';
	}
	
	
}

?>