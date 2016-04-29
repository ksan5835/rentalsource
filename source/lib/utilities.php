<?php

//include_once(SERVER_ADMINROOT . '/lib/dmlib.php');
include(SERVER_ROOT . '/lib/fckeditor/fckeditor.php') ;

class utilities {
	
	function createEditor($name,$value)
	{
		$sBasePath = 'lib/fckeditor/' ;
		$oFCKeditor = new FCKeditor($name) ;
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->Config['AutoDetectLanguage']	= false ;
		$oFCKeditor->Config['DefaultLanguage']		= 'en';
		$oFCKeditor->Height = '350' ; 
		$oFCKeditor->Width = '550' ;
		//$oFCKeditor->ToolbarSet	= 'customtoolbarset' ;//FOR LIMITED TOOLBAR BUTTONS
		$oFCKeditor->Value		= $value;
		$oFCKeditor->Create() ;
	}

	
}

?>