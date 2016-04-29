<?php

include_once(SERVER_ROOT . '/lib/dmlib.php');
include_once(SERVER_ROOT . '/lib/emailcontents.php');
include_once(SERVER_ROOT . '/lib/imagehandler.php');

class user {

public function checkLogin($arrData)
{
		$query = mysql_query("SELECT * from ".TBL_PREFIX."admin_users where username='".$arrData['username']."' and userpassword='".$arrData['password']."'");
		$userdetails = @mysql_fetch_array($query);	
		return $userdetails;
}

public function rand_string( $length) {

	$str ="";
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}
	return $str;
}

	
}

?>