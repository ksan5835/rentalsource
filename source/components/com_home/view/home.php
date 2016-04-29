<?php
include_once(SERVER_ROOT . '/templates/mblue/header.html');
?>

<div class="loginbox">

<form name="frmlogin" method="post" action="<?php echo SITE_ROOT;?>/index.php">
<table border="0" width="90%" cellpadding="0" cellspacing="10">
<tr><td align="center"><strong>Administrator</strong></td></tr>
<tr><td>User Name</td></tr>
<tr><td><input type="text" name="txtusername" id="txtusername"  class="textinput " /></td></tr>
<tr><td>Password</td></tr>
<tr><td><input type="password" name="txtpassword" id="txtpassword" class="textinput " /></td></tr>
<tr><td align="center"><input type="submit" name="btnsubmit" value="Login" class="rstpwd"/></td></tr>
</table>
<input type="hidden" name="task" value="login" />
<input type="hidden" name="option" value="com_user" />	
</form>	

<div align="center" style="font-size:16px; margin-left:-26px; color:#FF0000;">
<?php
	if(@$_SESSION['error_msg'])
	{
		echo "<div class='displaysignmsg'>".$_SESSION['error_msg']."</div>";
		unset($_SESSION['error_msg']);
	
	}

?>
</div>
</div>

<?php
include_once(SERVER_ROOT . '/templates/mblue/footer.html');
?>