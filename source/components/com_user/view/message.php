<?php
include_once(SERVER_ROOT . '/templates/mblue/header.html');
?>

<!--middle-content-->
<div class="maindiv_second">
<div class="left">
<div class="inner-img">
<img  src="<?php echo SITE_ROOT; ?>/templates/mblue/images/left-main-profile-pic.png" width="373px" height="361px" /></div>

<div class="profile-type">
<div class="profile-head">
<h2>Your Profile</h2>
</div>
<div class="profile-text">
<ul>
<li>Create your online profile on the web
</li>
<li>Build your professional network and exchange ideas
</li>
<li>Connect with people who share the same interest</li>
</ul>
</div>
</div>

</div>



<div class="right">

<div class="login-main1">
<table width="98%" class="login-inner-table1">
<tr>
  <th align="left"><h2 class="info">Information!</h2></th>
 </tr> 
<tr>
<td>
<?php
	if(@$_SESSION['error_msg'])
	{
		echo "<div class='displaysignmsg'>".$_SESSION['error_msg']."</div>";
		unset($_SESSION['error_msg']);
	
	}

?>
</td>
</tr>

</table>
</div>

</div>
</div>




<?php
include_once(SERVER_ROOT . '/templates/mblue/footer.html');
?>