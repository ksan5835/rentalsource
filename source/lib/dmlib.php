<?php

class dbquery {

function insert_table($arrFielsValue,$tableName)
{

$index = 1;
//print_r($arrFielsValue);
foreach($arrFielsValue as $key=>$value)
  {    
  //echo $value."<br />".$index;
	if(isset($value))
	{
	
	if($index == 1)
	{
	  	$query1 = "(".$key;
		$query2 = "('".addslashes($value)."'";
		
	 }
	else
	{	
		$query1 .= ",".$key;
		$query2 .= ",'".addslashes($value)."'";
	 }
	
	}
	$index++;
  }
  $query1 .= ")";
  $query2 .= ")";
  $finalquery = "insert into ".$tableName.$query1." values".$query2;   
  $success = mysql_query($finalquery);
  return $success;
}


function update_table($arrFielsValue,$tableName,$id)
{

$index = 1;
foreach($arrFielsValue as $key=>$value)
  {    
	//if($value)
	//{
	
	if($index == 1)
	{
	  	$query1 = $key."='".addslashes($value)."'";
		
	 }
	else
	{	
		$query1 .= ",".$key."='".addslashes($value)."'";
		
	 }
	
	//}
	$index++;
  } 
  $finalquery = "update ".$tableName." set ".$query1." where id='".$id."'"; 
  
   $success = mysql_query($finalquery);
  return $success;
}

function delete_record_by_id($tableName,$id)
{
  $finalquery = "delete from ".$tableName." where id='".$id."'";  
  $success = mysql_query($finalquery);
  return $success;
}

function get_page_contents($pagename)
{
  $page_contents = mysql_query("SELECT * from univarr_page_contents WHERE page_id='".$pagename."'");
  $check_res = @mysql_fetch_array($page_contents);
  return $check_res;
}

function get_site_config($userid)
{
  $page_contents = mysql_query("SELECT * from ek_site_config where ek_user_id='".$userid."'");
  $check_res = @mysql_fetch_array($page_contents);
  return $check_res;
}

function get_page_title_by_id($pagename)
{
  $page_contents = mysql_query("SELECT * from univarr_pages WHERE id='".$pagename."'");
  $check_res = @mysql_fetch_array($page_contents);
  return $check_res;
}


function checkadminlogin($username)
{
   if($username=="admin@gmail.com")
   {
     return "admin";
   }
   else
   {
     return "user";
   }
}

function get_user_info($id)
{
   $user_details = mysql_query("SELECT * from r2o_user WHERE id='".$id."'");
   $user_detail = @mysql_fetch_array($user_details);
   return $user_detail;
}

function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
		$consonants .= '23456789';
		$consonants .= '@#$%';
		$vowels .= "AEUY";
	}
	 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}
function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
 function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth ,$fname) 
{
  // open the directory
  $dir = opendir( $pathToImages );

  // loop through it, looking for any/all JPG files:

    // parse path for the extension
    $info = pathinfo($pathToImages . $fname);
    // continue only if this is a JPEG image
    if ( strtolower($info['extension']) == 'jpg' ) 
    {
      // load image and get image size
      $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
      $width = imagesx( $img );
      $height = imagesy( $img );

      // calculate thumbnail size
      $new_width = $thumbWidth;
      $new_height = floor( $height * ( $thumbWidth / $width ) );

      // create a new tempopary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

      // copy and resize old image into new image 
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

      // save thumbnail into a file
      imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
    }
   // close the directory
  closedir( $dir );
}

function insert_update_item_hit_count($item_id,$category,$page)
{
  $page_hits = mysql_query("SELECT * from svf_popular_items_hits WHERE item_id='".$item_id."' and category='".$category."'");
  $page_hit_details = @mysql_fetch_array($page_hits);
  if($page_hit_details)
  {
	$hitcountincr = $page_hit_details['hit_count'] + 1;
	$update_id = $page_hit_details['id'];
	$arrInsert->hit_count = $hitcountincr;
	update_table($arrInsert,'svf_popular_items_hits',$update_id);
  }
  else
  {
	$arrInsert->item_id = $item_id;
	$arrInsert->category = $category;
	$arrInsert->page = $page;
	$arrInsert->hit_count = 1;
	$value = insert_table($arrInsert,'svf_popular_items_hits');
  }
}

function createThumbs2( $pathToImages, $pathToThumbs, $thumbWidth,$thumbHeight ,$fname) 
{

  // open the directory
  $dir = opendir( $pathToImages );

  // loop through it, looking for any/all JPG files:

    // parse path for the extension
    $info = pathinfo($pathToImages . $fname);
    // continue only if this is a JPEG image
    if ( strtolower($info['extension']) == 'jpg' || 'png' || 'gif' ) 
    {
      // load image and get image size
      $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
      $width = imagesx( $img );
      $height = imagesy( $img );

      // calculate thumbnail size
      $new_width = $thumbWidth;
      //$new_height = floor( $height * ( $thumbWidth / $width ) );
	  $new_height = $thumbHeight;

      // create a new tempopary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

      // copy and resize old image into new image 
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

      // save thumbnail into a file
      imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
    }
   // close the directory
  closedir( $dir );
}


}
?>