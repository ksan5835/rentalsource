<?php
include_once("model/user.php");

class com_user_Controller {
	
	public $model;
	
	public function __construct()  
    {  
  
    } 
	
	public function invoke($view,$task)
	{
		
		if($task)
		{
		
		switch($task)
		{
			case "register":
				$this->registerProfile();
			break;
			case "checkemail":
				$this->checkUserEmail();
			break;
			case "activate":
				$this->activateAccount();
			break;			
			case "login":
				$this->checklogin($_POST);
			break;
			case "logout":
				$this->logout();
			break;
		}
		
		
					
		}
		else
		{
		
			include 'view/'.$view.'.php';
			/*if($view=="message")
			{
				$this->showPage();
			}*/
								
		}
		
		
	}
	
	
	public function showPage()
	{	    
		//$objPage = new page();
		//$stateLists = $objPage->getUserStates();
		include 'view/home.php';
	}
	
	public function checklogin()
	{
				  
		  $username = trim($_REQUEST['txtusername']);
		  $password = trim($_REQUEST['txtpassword']);		
		  
		  $arrData['username'] = $username;		  
		  $arrData['password'] = md5($password);

		  $objPage = new user();
		  $userDetails = $objPage->checkLogin($arrData);
		  if($userDetails)
		  {
		   		if($userDetails['active_status'] == 0)
				{
					$_SESSION['error_msg'] = "Your Account not yet activated. Please activate your account";
					header("location: index.php?option=com_user&view=message");
				}
				else
				{				
					$_SESSION['susername'] = $username;
					$_SESSION['spassword'] = $password;
					$_SESSION['suserid'] = $userDetails['id'];		
					$_SESSION['srole'] = $userDetails['user_type'];
					$_SESSION['sprofile'] = $userDetails['profile_type'];					
					header("location: index.php?option=com_pos&view=dashboard");
				}
				
		  }
		  else
		  {
		   		$_SESSION['error_msg'] = "Invalid Login";
				header("location: index.php");
		  }
	}
	
	
	public function registerProfile()
	{
		$objPage = new user();
		$stateLists = $objPage->insertUserRegistration($_POST);
		header("location: index.php");
	}
	
	//check user email exists
	public function checkUserEmail()
	{
		$value = $_REQUEST['email'];
		$objPage = new user();
		$recExists = $objPage->checkUserEmailExists($value);
		if($recExists)		
			echo "exists";
		else
			echo false;
		
	}
	
	public function logout()
	{						
			unset($_SESSION['susername']);
			unset($_SESSION['spassword']);
			unset($_SESSION['suserid']);
			unset($_SESSION['sprofile']);
			unset($_SESSION['srole']);
			header("location: index.php");	
	}
	
	
	public function activateAccount()
	{
			$token = $_REQUEST['token'];			
			$objPage = new user();
			$tokenDetails = $objPage ->checktoken($token);	
			
			if($tokenDetails)
			{
				$userDetails = $objPage ->getUserDetailsByID($tokenDetails['user_id']);
				$arrData['active'] = 1;
				$objPage->updateUserDetails($arrData,$userDetails['id']);
				$objPage->deleteUserTokenByID($tokenDetails['id']);
				$_SESSION['error_msg'] = "Your account has been activated successfully.";
			
				//send email to user
				$userMailDetails['email'] = $userDetails['email'];
				$userMailDetails['name'] = $userDetails['firstName']." ".$userDetails['lastName'];
				$userMailDetails['username'] = $userDetails['email'];			
				$objPage->sendActivationSuccessMail($userMailDetails);			
				header("location: index.php");
			
			}
			else
			{
				$_SESSION['error_msg'] = "Invalid Access";
				header("location: index.php");
				//header("location: index.php?option=com_login&view=signup");
			}	
	}
	
	
}

?>