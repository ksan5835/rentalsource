<?php 
    require_once("config.php"); 	
	include_once("router.php");
	
	//get parameters
	$option = @$_REQUEST['option'];
	$task = @$_REQUEST['task'];
	$view = @$_REQUEST['view'];	
		
	if((@$_SESSION['susername'] != "") and (@$_SESSION['spassword'] != ""))
	{
		if($option == "")
		{
		 	$option = "com_pos";
		 	$view = "dashboard";		 
		}
	}
	
	
	$objRouter = new routerPage();
	$objRouter->option = $option;
	$objRouter->task = $task;
	$objRouter->view = $view;		
	
	//route the page
	$objRouter->routepage();
?>