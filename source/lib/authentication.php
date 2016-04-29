<?php

//include_once("model/Book.php");

class userauthentication {
	
	
	public function checkUserLogin($arrData)
	{		
		$reText = "invalid";
		$username = $arrData["txtname"];		
		$password = $arrData["txtpassword"];		
		$encryptpassword = md5($arrData["txtpassword"]);
		$check_username = mysql_query("SELECT * from ".TBL_PREFIX."admin_users where username='".$username."' and userpassword='".$encryptpassword."'");		
		$check_res = @mysql_fetch_array($check_username);
		if($check_res)
		{	
			$reText = "success";			
		}
		else
		{
		  $reText = "invalid";		  
		}
		
		return $reText;	
	
	}
		
	
}

?>