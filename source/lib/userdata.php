<?php
include_once(SERVER_ROOT . '/lib/dmlib.php');
if($userDetails)
{
	$userSmallThumb = $userDetails['profileImage'] ? "profile_images/smallthumbs/".$userDetails['profileImage']:'templates/mblue/images/cus-icon.png';
	$userMediumThumb = $userDetails['profileImage'] ? "profile_images/thumbs/".$userDetails['profileImage']:'templates/mblue/images/big-cus-icon.png';
	$userProjectCount = getUserProjectCount($userDetails['id']);
	$userHobbies = getUserHobbies($userDetails['id']);
	$userShortName = substr(ucfirst($userDetails['firstName']),0,9);
	$userFullName = ucfirst($userDetails['firstName']);
	$userAge = age_from_dob($userDetails['DOB']);
	$userTotExp = $userDetails['totExp'];
	
}



function getUserProjectCount($userId)
{
	$result = mysql_query("SELECT * FROM mpb_user_projects where userId=".$userId);
	$num_rows = mysql_num_rows($result);
	return $num_rows;
}

function getUserHobbies($userId)
{
 	$query = mysql_query("SELECT * from mpb_user_hobbies where user_id='".$userId."'");
	$recDetails = @mysql_fetch_array($query);
	if($recDetails)
		$userHobbies = stripslashes($recDetails['hobbies']);
	else
		$userHobbies = "";
	return $userHobbies;
	
}

function age_from_dob($dob) {

    list($d,$m,$y) = explode('-', $dob);
   
    if (($m = (date('m') - $m)) < 0) {
        $y++;
    } elseif ($m == 0 && date('d') - $d < 0) {
        $y++;
    }
   
    return date('Y') - $y;
   
}


?>