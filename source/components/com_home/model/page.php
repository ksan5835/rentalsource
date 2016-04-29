<?php

include_once(SERVER_ROOT . '/lib/dmlib.php');

class page {
	
public function insertUpdatePageContents($arrData)
{
	$db = new dbquery();
	
	$arrInsert["page_title"] = addslashes($arrData["page_title"]);
	$arrInsert["page_text"] = addslashes($arrData["page_text"]);
	$arrInsert["page_meta_title"] = addslashes($arrData["page_meta_title"]);
	$arrInsert["page_meta_tags"] = addslashes($arrData["page_meta_tags"]);
	$arrInsert["page_meta_description"] = addslashes($arrData["page_meta_description"]);
	$arrInsert["active_status"] = 1;
	
	if($arrData["update_id"] == "0")
	{
		$db->insert_table($arrInsert,'ek_page_contents');
	}
	else
	{
	    $db->update_table($arrInsert,'ek_page_contents',$arrData["update_id"]);
	} 
}

public function checkuserloginhome($value,$field)
{
	if($field == "username")
	{
		$query = mysql_query("SELECT * from ek_rummy_users where user_name='".$value."'");
	}
	
	if($field == "email")
	{
		$query = mysql_query("SELECT * from ek_rummy_users where email='".$value."'");
	}
	
	$userdetails = @mysql_fetch_array($query);
	
	return $userdetails;
}

public function getPageLists()
{
	$pageLists = mysql_query("SELECT * from ek_page_contents");		
	while ($row = mysql_fetch_assoc($pageLists)) {
		$pagelist[] =  $row;
	}		
	return @$pagelist;
}

public function getPageByID($id)
{
	$query = mysql_query("SELECT * from ek_page_contents where id='".$id."'");
	$pageDetails = @mysql_fetch_array($query);
	return @$pageDetails;	
}	

public function deletePageById($id)
{
	$db = new dbquery();
	$db->delete_record_by_id("ek_page_contents",$id);
}

public function getUserStates()
{
	$db = new dbquery();
	$query = mysql_query("SELECT * from ek_rummy_states");
	while ($row = mysql_fetch_assoc($query)) {
		$states[] =  $row;
	}
	return @$states;
}

}

?>