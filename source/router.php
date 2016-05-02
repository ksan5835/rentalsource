<?php
class routerPage {

public $option;
public $task;
public $view;

public function routepage()
{

$cOption = $this->option ? $this->option:'com_home';
$cView = $this->view ? $this->view:'home';
$task = $this->task ? $this->task:'';

$target = SERVER_ROOT . '/components/'.$cOption.'/Controller.php';

//get target
if (file_exists($target))
{
	include_once($target);
	
	//modify page to fit naming convention
	$class = ucfirst($cOption) . '_Controller';
	
	//instantiate the appropriate class
	if (class_exists($class))
	{
		$controller = new $class;
	}
	else
	{
		//did we name our class correctly?
		die('class does not exist!');
	}
	
	$controller->invoke($cView,$task);
}
else
{
	//can't find the file in 'controllers'! 
	die('page does not exist!');
}

}

}