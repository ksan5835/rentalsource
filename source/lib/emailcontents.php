<?php

include "class.phpmailer.php";

class emailcontents {
	
	
	public function forgotpasswordemail($arrData)
	{
	
$message = '
Hi '.$arrData['name'].',<br>We have received your forgot username/password request.<br>Your EK Rummy Username is. '.$arrData['username'].'<br>You can also reset your password by clicking on the following URL<br><a href="'.$arrData['passwordlink'].'">'.$arrData['passwordlink'].'</a><br>If you are facing trouble with the link provided please contact us at support@ekrummy.com<br>Regards<br>EKRummy Team 
	 ';
	return $message;
	
	}
	
	public function getActivationEmailContents($arrData)
	{
		$message ='
		Hi '.$arrData['name'].',<br><br>Thanks for registering at '.SITE_NAME.',<br><br>Please click on the link below or copy the link in your browser to activate your account:<br><br><a href="'.$arrData['activatelink'].'">'.$arrData['activatelink'].'</a><br><br>Once you activate, you can login and create your profile!<br><br>Thanks,<br> Admin.';
		return $message;	
	
	}
	
	public function getActivationSuccessContents($arrData)
	{
		$message ='
		Hi '.$arrData['name'].',<br><br>Thanks for registering at '.SITE_NAME.',<br><br>Your Account has been registered successfully!<br><br>Username:'.$arrData['username'].'<br><br>Enjoy the game!!! Earn the unlimited money!!!<br><br>Cheers,<br>'.SITE_NAME.' Admin.';
		return $message;		
	}
	
	
	
	public function sendEmail($message,$toemail,$subject)
	{

			/*$headers1 = "From: Rajproperties Support < admin@rajproperties.com >\r\n";
			$headers1 .= "Reply-To: Rajproperties Support < admin@rajproperties.com >\r\n";
			$headers1 .= "Return-Path: Rajproperties Support < admin@rajproperties.com >\r\n";
			//$headers .= "CC: susan@example.com\r\n";
			$headers1 .= "MIME-Version: 1.0\r\n";
			$headers1 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";		
		    $result = mail($toemail, $subject, $message,$headers);
		    */
			$mail = new PHPMailer(); // create a new object
			$mail->IsSMTP(); // enable SMTP
			$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
			$mail->SMTPAuth = true; // authentication enabled
			$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 465; // or 587
			$mail->IsHTML(true);
			$mail->Username = "maintenance.rajproperties@gmail.com";
			$mail->Password = "Raj@123prop4#";
			$mail->SetFrom("maintenance.rajproperties@gmail.com");
			$mail->Subject = $subject;
			$mail->Body = $message;
			$mail->AddAddress($toemail);
			if(!$mail->Send()){
			//echo "Mailer Error: " . $mail->ErrorInfo;
				$result = "Error";
			}
			else{
			//echo "Message has been sent";
			   $result = "Message has been sent";
			}
			
			return $result;	
	
	}
	
	public function getContactUsEmailContents($arrData)
	{
	  $message ='<b>Name</b>:'.$arrData['name'].'<br><b>Email</b>:'.$arrData['email'].'<br><b>Contact Number</b>:'.$arrData['c_number'].'<br><b>Address</b><br>'.$arrData['address'];
	  return $message;
	}
	
	public function getMaintainanaceEmailContents($arrData)
	{
		
		$message  = "<html><head><style type='text/css'>";
        $message .= "* {padding:0px;margin:0px;} body{font-size:13px;}";
        $message .= "p {font-weight:bold;line-height:18px;font-size:13px;padding-bottom:5px;padding-top:10px;font-family:Tahoma;color:#272727;}";
        $message .= "p span {font-weight:normal;line-height:18px;font-size:13px;padding-bottom:5px;padding-top:10px;font-family:Tahoma;color:#272727;}";
        $message .= ".comments{background-color:#f3f3f3;border:1px solid #ccc;font-size:10px;}";
        $message .= ".notes{font-weight:bold;line-height:18px;font-size:13px;padding-bottom:5px;padding-top:10px;font-family:Tahoma;color:#272727;font-style:italic;}";
        $message .= "</style></head><body>";

        $message .= "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
        $message .= "<tr><td colspan='2' align='center'><p>".$arrData['prop_address']."</p></td></tr>";
        //$message .= "<tr><td width='70%' style='font-size:22px; font-weight:bold;' align='center'>".$arrData['prop_address']."</td><td align='right' style='font-size:22px; font-weight:bold;'>".$arrData['prop_location']."</td></tr>";
        $message .= "<tr><td colspan='2'><p><b>It is the policy of Raj Properties to require that this maintenance request form be filled out completely by tenants before a maintenance appointment is scheduled.</b></p></td></tr>";
        $message .= "<tr><td><p>Apartment Number : <span>".$arrData['apart_number']."</span></p></td><td align='right'><p>Date of Request : <span>".date("d-m-Y")."</span></p></td></tr>";




        $message .= "<tr><td colspan='2'><p><b>Please list repairs requiring Maintenance</b></p><div class='comments'>".$arrData['area_maintainance']."</div></td></tr>";
        $message .= "<tr><td colspan='2'><p><b>In the event that I am not present at the time of repair, I hereby authorize maintenance personnel to enter my apartment in my absence</b></p></td></tr>";
        $message .= "<tr><td colspan='2'><p>Please Indicate: <span></span></p></td></tr>";
        $message .= "<tr><td><p>Full Name(Tenant): <span>".$arrData['name']."</span></p></td><td><p>Datetime Phone: <span>".$arrData['p_number']."</span></p></td></tr>";
        $message .= "<tr><td><p>Signed(Tenant): <span>&nbsp;</span></p></td><td><p>Evening Phone: <span>".$arrData['pevening_number']."</span></p></td></tr>";
        $message .= "<tr><td colspan='2'><p><span>Maintenance personnel are available Monday through Friday from 8.00AM to 5.00 PM. If you would like to be present during the maintenance visit, please list two dates and times, in order of preference, that you will be available at the apartment. Our maintenance personnel will arrive at the time you indicate, if possible, and will not enter if you are not present</span></p></td></tr>";
        $message .= "<tr><td colspan='2'>";
        $message .= "<table border='1' cellpadding='0' cellspacing='0'  width='80%' align='center' style='margin:auto;'>";
        $message .= "<tr><th>Preference</th><th>Date Available (Monday - Friday)</th><th>Time(8 AM - 5 PM Only)</th></tr>";
        $message .= "<tr><td>First</td><td>".$arrData['pretime1']."</td><td>".$arrData['from_preferedtime1']."</td></tr>";
        $message .= "<tr><td>Second</td><td>".$arrData['pretime2']."</td><td>".$arrData['from_backuptime2']."</td></tr>";
        $message .= "</table>";
        $message .= "</td></tr>";
        $message .= "<tr><td colspan='2'><br /><div class='comments'>";
        $message .= "<table border='0' width='100%'>";
        $message .= "<tr><td><p>Maintenance Person Assigned:</p></td><td><p>Date Completed:</p></td></tr>";
        $message .= "<tr><td><p>Time Started:</p></td><td><p>Time Completed:</p></td></tr>";
        $message .= "<tr><td colspan='2'><strong>Action taken or Comments(Maintenance Person)</strong><br /><div style='height:50px;border:1px solid #000;padding:10px;'></div></td></tr>";
		 $message .= "<tr><td colspan='2'><p>Signature (Maintenance Person):</p></td></tr>";
        $message .= "<tr><td colspan='2'><span class='notes'>(Maintenance person: Please have the tenant sign the bottom of the form if he/she is available).</span></td></tr>";
        $message .= "</table>";
        $message .= "</div><br>";
        $message .= "</td></tr>";
        $message .= "<tr><td colspan='2'>";
        $message .= "<div class='comments'>";
        $message .= "<table border='0' width='100%'>";
        $message .= "<tr><td colspan='2'><p>Tenant: When repairs are complete, pleaes complete the following</p></td></tr>";
        $message .= "<tr><td colspan='2'><p>Requested repairs have been completed to my satisfaction (Yes/No):</p></td></tr>";
        $message .= "<tr><td colspan='2'><p>If there are other repairs, please fill out a new Maintenance Request Form. Thank you!</p></td></tr>";
        $message .= "<tr><td colspan='2'><p>Full Name(Tenant):</p></td></tr>";
        $message .= "<tr><td><p>Signed(Tenant):</p></td><td><p>Date: </p></td></tr>";
        $message .= "</table>";
        $message .= "</div>";
        $message .= "</td></tr></table></body></html>";		
		
	  //$message = '<b>Property Address</b>:'.$arrData['prop_address'].'<br><b>Apartment Number</b>:'.$arrData['apart_number'].'<br><b>Area Description</b>:'.$arrData['area_maintainance'].'<br><b>Name</b>:'.$arrData['name'].'<br><b>Email</b>:'.$arrData['email'].'<br><b>Contact Number</b>:'.$arrData['p_number'];
	  return $message;
	}
	
	public function getBuildingLocationEmailContents($arrData)
	{
	  $message = '<b>Name</b>:'.$arrData['contact_uname'].'<br><b>Email</b>:'.$arrData['contact_email'].'<br><b>Contact Number</b>:'.$arrData['contact_number'].'<br><b>Comments</b>:'.$arrData['comments'];
	  return $message;
	}
	
	public function getParkingEmailContents($arrData)
	{
	 $message ='<b>Name</b>:'.$arrData['p_name'].'<br><b>Email</b>:'.$arrData['email'].'<br><b>Contact Number</b>:'.$arrData['c_number'];
	  return $message;
	}
	
	public function getContactUsEmailAcknowldege()
	{
		$message ='Hi, <br />Thank you for contacting '.SITE_NAME.'.We acknowledge your query and it is being handled as high priority. We will respond you with the best possible solution. We appreciate your patience in this regard and thank you for giving us the opportunity to serve you.<br /><br />Best Wishes,<br />'.SITE_NAME.' Team.<br />';
		return $message;
	}
	
}

?>