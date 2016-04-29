<?php
include_once(SERVER_ROOT . '/templates/mblue/header.html');
?>

<!--middle-content-->
<div class="maindiv">
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

<div class="login-main">
<table width="98%" class="login-inner-table">
<tr>
  <th colspan="3" align="left">Login</th>
 </tr>
<tr>
  <td><input class="text-box" type="text" placeholder="Your E-mail Address" /></td> <td><input type="text" class="text-box" placeholder="Your Password" /></td> <td><a href="#"><img src="<?php echo SITE_ROOT; ?>/templates/mblue/images/login.png" /></a></td>
 </tr>
 <tr>
  <td><table><tr><td><div style="padding:6px 0; position:relative; left:-4px;"><input type="checkbox" /></div></td><td><span class="normal-small">Remember me</span></td></tr></table></td> <td><span class="normal-small"><a href="#">Forgot Password?</a></span></td> <td></td>
 </tr>

</table>
</div>

<div class="login-main1">
<form name="frmregister" method="post" action="index.php?option=com_user&task=register">

<table width="98%" class="login-inner-table1">
<tr>
  <th colspan="2" align="left">Create Your Profile</th>
 </tr> 
<tr>
  <td align="left" colspan="2"><div style=" border-top:3px solid #e7e7e7; height:1px; width:418px;"></div></td>
 </tr>
<tr>
  <td align="left"><span class="normal-small1">First Name</span></td> <td width="75%"><input type="text" class="text-box1" placeholder="" /></td>
 </tr>
 <tr>
  <td align="left"><span class="normal-small1">Last Name</span></td> <td><input type="text" class="text-box1" placeholder="" /></td> 
 </tr>
 <tr>
  <td align="left"><span class="normal-small1">E-mail</span></td> <td><input type="text" class="text-box1" placeholder="" /></td> 
 </tr>
 <tr>
  <td align="left"><span class="normal-small1">Password</span></td> <td><input type="text" class="text-box1" placeholder="" /></td> 
 </tr>
 <tr>
  <td align="left"><span class="normal-small1">Mobile</span></td> <td><input type="text" class="text-box1" placeholder="" /></td> 
 </tr>
 <tr>
  <td width="25%" align="left"><span class="normal-small12">Gender</span></td> <td width="75%" valign="top"><select class="select-box1"><option>Select</option></select></td>
 </tr>
  <tr>
  <td width="25%" align="left"><span class="normal-small1">Short URL</span></td> <td width="75%"><input type="text" class="text-box1" placeholder="" /></td>
 </tr>
 <tr><td colspan="3" align="center"> <input type="submit" value="" name="btn_submit" class="submitregisteer" /></td></tr>
</table>
</form>

</div>

</div>
</div>




<?php
include_once(SERVER_ROOT . '/templates/mblue/footer.html');
?>