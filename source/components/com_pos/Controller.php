<?php
include_once("model/pos.php");
include_once(SERVER_ROOT . '/lib/authentication.php');


class com_pos_Controller {
	
	public $model;
	
	public function __construct()  
    {  
  		$this->checkUserAuth();
    } 
	
	public function invoke($view,$task)
	{
		
		if($task)
		{
		
		switch($task)
		{			
			case "userform":
			    $uid = $_POST['uid'];
				$rtText = $this->getUserForm($uid);
				echo $rtText;
			break;
			case "adduser":
				$this->insertUpdateUser($_POST);
			break;
			case "uploaddoc":
				$objPage = new possale();
				$objPage->uploaddoc($_POST);
				header("location: index.php?option=com_pos&view=addclient&cid=".$_POST['cID']."&edit=1");
			break;
			case "updateDocStatus":
				$objPage = new possale();
				$objPage->updateDocStatus($_POST);
				header("location: index.php?option=com_pos&view=addclient&cid=".$_POST['cID']."&edit=1");
			break;
			case "generateInv":
				$this->generateInvoice($_POST);
			break;
			case "generateInvnew":
				$this->generateInvoiceNew($_POST);
			break;
			case "addClient":
				$this->insertUpdateClient($_POST);
			break;
			case "clientform":
			    $cid = $_POST['cid'];
				$rtText = $this->getClientForm($cid);
				echo $rtText;
			break;
			case "paymentstatus":
			    $cid = $_POST['cid'];
				$rtText = $this->getPaymentForm($cid);
				echo $rtText;
			break;
			case "sendinvoicemail":
			    $cid = $_POST['cid'];
				$rtText = $this->sentInvoiceMail($cid);
				echo $rtText;
			break;
			case "clientdelete":
			 	$recId = $_POST['recid'];
				$objPage = new possale();
				//$arrInsertData['table_name'] = "client";
				//$arrInsertData['record_id'] = $recId;
				$objPage->updateClientTrashStatus($recId);
			break;
			case "systemdelete":
			 	$recId = $_POST['recid'];
				$objPage = new possale();
				//$arrInsertData['table_name'] = "client";
				//$arrInsertData['record_id'] = $recId;
				$objPage->updateSystemTrashStatus($recId);
			break;
			case "systemform":
			    $cid = $_POST['cid'];
				$rtText = $this->getSystemForm($cid);
				echo $rtText;
			break;
			case "onOfficeSysForm":
			    $cid = $_POST['cid'];
				$rtText = $this->getOnOfficeSysForm($cid);
				echo $rtText;
			break;
			case "addupdateSysInfo":
				$this->insertUpdateSysInfo($_POST);
			break;
			case "updatePaymentStatus":
				$this->updatePaymentStatusInfo($_POST);
			break;
			case "saveOnofficeSys":
				$this->saveOnofficeSys($_POST);
			break;
			case "usershowupdate":
			    $recId = $_POST['recid'];
				$arrInserUpdateData['active_status'] = $_POST['sStatus'];	 	
				$this->updateUserData($arrInserUpdateData,$recId);
			break;
			case "userdelete":
			 	$recId = $_POST['recid'];
				$this->deleteUser($recId);
			break;
			case "leadform":
			    $cid = $_POST['cid'];
				$rtText = $this->get_new_order_form($cid);
				echo $rtText;
			break;
			case "serviceform":
			    $cid = $_POST['cid'];
				$rtText = $this->get_new_service_form($cid);
				echo $rtText;
			break;
			case "addnewlead": 
				$this->insertUpdateNewLeads($_POST);
			break;
			case "addnewservice": 
				$this->insertUpdateNewServices($_POST);
			break;
			case "accountform":
			    $cid = $_POST['cid'];
				$rtText = $this->get_new_account_form($cid);
				echo $rtText;
			break;
			case "chequeform":
			    $cid = $_POST['cid'];
				$rtText = $this->get_new_cheque_form($cid);
				echo $rtText;
			break;
			case "accountformservice":
			    $cid = $_POST['cid'];
				$rtText = $this->get_new_service_account_form($cid);
				echo $rtText;
			break;
			case "addnewaccentry": 
				$this->insertUpdateNewAccEntry($_POST);
			break;
			case "addnewchequeentry": 
				$this->insertUpdateNewChequeEntry($_POST);
			break;
			case "addnewaccservice": 
				$this->insertUpdateNewServiceAccEntry($_POST);
			break;
			case "closeaccount": 
				$this->closeAccountStatement($_POST);
			break;
			case "dwlreport": 
				$this->downloadClientReport($_POST);
			break;
			case "trashinvoice":
				$this->trashInvoiceById($_POST);
			break;
			case "trashservice":
				$this->trashServiceById($_POST);
			break;
			case "trashlead":
				$this->trashLeadById($_POST);
			break;
			case "trashcheque":
				$this->trashChequeById($_POST);
			break;
			case "downaccreport": 
				$this->downloadAccountReport($_POST);
			break;
			case "downacclastreport": 
				$this->downloadAccountLastReport($_POST);
			break;
		
		}
		
		
					
		}
		else
		{		
			$objPage = new possale();
			$userDetails = $objPage ->getUserDetailsByID($_SESSION['suserid']);			
			include 'view/'.$view.'.php';			
								
		}
		
		
	}
	
	function trashInvoiceById($arrData)
	{
		$recID = $arrData['recid'];
		$objPage = new possale();
        $objPage->updateInvoiceTrashStatus($recID);
	}
	
	function trashServiceById($arrData)
	{
		$recID = $arrData['recid'];
		$objPage = new possale();
        $objPage->updateServiceTrashStatus($recID);
	}
	
	function trashLeadById($arrData)
	{
		$recID = $arrData['recid'];
		$objPage = new possale();
        $objPage->updateLeadTrashStatus($recID);
	}
	
	function trashChequeById($arrData)
	{
		$recID = $arrData['recid'];
		$objPage = new possale();
        $objPage->updateChequeTrashStatus($recID);
	}
	
	function downloadAccountLastReport($arrData)
	{
		  $objPage = new possale();
		  
		   $extraquery = "rec_active_status=0 and MONTH( expense_date ) = (MONTH(NOW()) - 1)";  
		  
		  @$entryLists = $objPage->getAccEntryLists($extraquery);
		  $strTotal =0;
		  if($entryLists)
			  {
				  $strReturnText = "";
			  for($i=0;$i<count(@$entryLists);$i++)
			  {			  
				  $exDate = date("d-m-Y",strtotime($entryLists[$i]['expense_date']));				  
				  $strReturnText .= '<tr>';
				  $strReturnText .= '<td>'.($i + 1).'</td>';
				  $strReturnText .= '<td>'.$entryLists[$i]['description'].'</td>';
				   $strReturnText .= '<td>'.$entryLists[$i]['cash_type'].'</td>';
				  $strReturnText .= '<td>'.$entryLists[$i]['expense_type'].'</td>';
				  $strReturnText .= '<td>'.$exDate.'</td>';
				  $strReturnText .= '<td>'.$entryLists[$i]['entry_amount'].'</td>';				 
				  $strReturnText .= '</tr>';
			  }
		  
		  }
		  
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment;Filename=Accounts_Report.xls");
		  
		  echo "<table border='1'>";
		  echo '<tr><th width="5%">S.No</th><th>Description</th><th style="width:15%">Transaction Type</th><th style="width:15%">Type</th><th style="width:15%">Date</th><th style="width:15%">Amount</th></tr>';
		  echo $strReturnText;		 
		  echo "<table>";
		  
		  die;

		
	}
	
	function downloadAccountReport($arrData)
	{
		  $objPage = new possale();
		  
		   $extraquery = "rec_active_status=1";
		  
		  @$entryLists = $objPage->getAccEntryLists($extraquery);
		  $strTotal =0;
		  if($entryLists)
			  {
				  $strReturnText = "";
			  for($i=0;$i<count(@$entryLists);$i++)
			  {			  
				  $exDate = date("d-m-Y",strtotime($entryLists[$i]['expense_date']));				  
				  $strReturnText .= '<tr>';
				  $strReturnText .= '<td>'.($i + 1).'</td>';
				  $strReturnText .= '<td>'.$entryLists[$i]['description'].'</td>';
				   $strReturnText .= '<td>'.$entryLists[$i]['cash_type'].'</td>';
				  $strReturnText .= '<td>'.$entryLists[$i]['expense_type'].'</td>';
				  $strReturnText .= '<td>'.$exDate.'</td>';
				  $strReturnText .= '<td>'.$entryLists[$i]['entry_amount'].'</td>';				 
				  $strReturnText .= '</tr>';
			  }
		  
		  }
		  
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment;Filename=Accounts_Report.xls");
		  
		  echo "<table border='1'>";
		  echo '<tr><th width="5%">S.No</th><th>Description</th><th style="width:15%">Transaction Type</th><th style="width:15%">Type</th><th style="width:15%">Date</th><th style="width:15%">Amount</th></tr>';
		  echo $strReturnText;		 
		  echo "<table>";
		  
		  die;

		
	}
	
	
	function downloadClientReport($arrData)
	{
		
		$objPage = new possale();	
		$stDay = $_POST['filstartdate'];
		$endDay = $_POST['filenddate'];
		$extrasql = " invoice_date between ".$stDay." and ".$endDay;
		
		@$clients = $objPage->getClientsLists($extrasql);
		if($clients)
		{
		$strClientLists = "";
		$strTotalIncome = 0;
		for($i=0;$i<count(@$clients);$i++)
		{
		//get total rental amount
		unset($totalSystemDetailsNew);
		$extraSql = "rental_status = 'yes' and client_id='".$clients[$i]['id']."'";
		$totalSystemDetailsNew = $objPage->getRecordByCustomQuery("system_details",$field="sum(total_amount) as totCount",$extraSql);
		$desktopcountPrice = ($totalSystemDetailsNew["totCount"]) ? $totalSystemDetailsNew["totCount"] : "0";
		
		$strTotalIncome +=  $desktopcountPrice;
		
		$strClientLists .= '<tr><td>'.($i + 1).'</td><td><span>'.$clients[$i]['organisation']." - ".$clients[$i]['client_name'].'</span></td><td>'.$clients[$i]['mobileno'].'</td><td align="right">'.$desktopcountPrice.'</td><td>'.$clients[$i]['invoice_date'].'</td></tr>';
		
		}
		}
		
		
		
		
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=Invoice_List.xls");
		
		echo "<table border='1'>";
		echo "<tr><th>S.No</th><th>Client</th><th>Mobile No</th><th>Invoice Amount</th><th>Invoice Day</th></tr>";
		echo $strClientLists;
		echo "<tr><td colspan='3' align='right'>Total Amount: Rs</td><td>".$strTotalIncome."</td><td>&nbsp;</td></tr>";
		echo "<table>";
		
		die;
	}
	
	function closeAccountStatement($arrData)
	{
		$objPage = new possale();		
		$objPage->closeAccountSummary($arrData);
		header("location: index.php?option=com_pos&view=accounts");
		die;
	}
		
	function insertUpdateNewAccEntry($arrData)
	{
		$objPage = new possale();		
		$objPage->insertUpdateAccEntry($arrData);
		header("location: index.php?option=com_pos&view=accounts");
	}
	
	function insertUpdateNewChequeEntry($arrData)
	{
		$objPage = new possale();		
		$objPage->insertUpdateChequeEntry($arrData);
		header("location: index.php?option=com_pos&view=cheque_details");
	}
		
	function insertUpdateNewServiceAccEntry($arrData)
	{
		$objPage = new possale();		
		$objPage->insertUpdateServiceAccEntry($arrData);
		header("location: index.php?option=com_pos&view=serviceaccounts");
	}
	
	function insertUpdateNewLeads($arrData)
	{
		$objPage = new possale();
		$objPage->insertUpdateNewLeads($arrData);
		header("location: index.php?option=com_pos&view=new_leads");
	}
	
	function insertUpdateNewServices($arrData)
	{
		$objPage = new possale();
		$objPage->insertUpdateNewServices($arrData);
		header("location: index.php?option=com_pos&view=service");
	}
	
	function insertUpdateUser($arrData)
	{			
		$objPage = new possale();
		$objPage->insertUpdateUser($arrData);
		header("location: index.php?option=com_pos&view=users");		
	}
	
	function generateInvoice($arrData)
	{			
		$objPage = new possale();
		$objPage->generateInvoiceDocument($arrData,'pdf');
		header("location: index.php?option=com_pos&view=invoice_details");		
	}
	
	function generateInvoiceNew($arrData)
	{			
		$objPage = new possale();
		$objPage->generateNewInvoiceDocument($arrData,'pdf');		
		header("location: index.php?option=com_pos&view=invoice_details");		
	}
	
	function insertUpdateClient($arrData)
	{			
		$objPage = new possale();
		$objPage->insertUpdateClient($arrData);
		header("location: index.php?option=com_pos&view=clients");		
	}
	
	function insertUpdateSysInfo($arrData)
	{			
		$objPage = new possale();
		$objPage->insertUpdateSysInfo($arrData);
		header("location: index.php?option=com_pos&view=client_view&cid=".$arrData['cId']);		
	}
	
	function updatePaymentStatusInfo($arrData)
	{			
		$objPage = new possale();

		$recID = $objPage->updatePaymentStatusInfo($arrData);
		
		if($arrData['cId'] != '' && $arrData['vId'] == ''){
			header("location: index.php?option=com_pos&view=invoice&cid=".$arrData['cId']);
		}elseif($arrData['vId']){
			header("location: index.php?option=com_pos&view=invoice&cid=".$arrData['cId']."&vid=".$arrData['vId']);
		}else{
			header("location: index.php?option=com_pos&view=invoice&rid=".$arrData['rId']);
		}
				
	}
	
	function saveOnofficeSys($arrData)
	{	
		$objPage = new possale();
		$objPage->saveOnofficeSys($arrData);
		header("location: index.php?option=com_pos&view=onoffice_systems");		
	}
	
	function updateUserData($arrData, $recID)
	{
		$objPage = new possale();
		$objPage->updateTableByTable("admin_users",$arrData,$recID);
	}
	
	function deleteUser($id)
	{
		$objPage = new possale();
		$arrInsertData['table_name'] = "admin_users";
		$arrInsertData['record_id'] = $id;
		$objPage->moveDataToTrash($arrInsertData);
	}
	
	function getUserForm($id="")
	{
		
		$objPage = new possale();
		$uDetails = $objPage->getAdminUserDetailsById($id);
		
		$chkStatus = "";
		if($uDetails)
		{
			$chkStatus = ($uDetails['active_status'] == 1) ? 'checked="checked"' : "";
		}
		
		$userroles  = array("admin","manager");
		
		$strSelect = "<select name='user_type'><option value=''>--Select--</option>";
		for($j=0;$j<count($userroles);$j++)
		{			
			$selStatus = (@$uDetails['user_type'] == $userroles[$j]) ? "selected='selected'" : "";
			$strSelect .= "<option value='".$userroles[$j]."' ".$selStatus.">".$userroles[$j]."</option>";
		}
		$strSelect .= "</select>";
		
		$strReturn ='
		
		<table>
		<tr><td>First Name</td><td><input type="text" class="textinputcommon" name="firstname" value="'.@$uDetails['firstname'].'" /></td></tr>
		<tr><td>Last Name</td><td><input type="text" class="textinputcommon" name="lastname" value="'.@$uDetails['lastname'].'" /></td></tr>
		<tr><td>Email</td><td><input type="text" class="textinputcommon" name="email" value="'.@$uDetails['email'].'" /></td></tr>
		<tr><td>Username</td><td><input type="text" class="textinputcommon" name="username" value="'.@$uDetails['username'].'" /></td></tr>
		<tr><td>Password</td><td><input type="password" class="textinputcommon" name="userpasswords" /></td></tr>
		<tr><td>Role</td><td>'.$strSelect.'</td></tr>
		<tr><td>Active</td><td><input type="checkbox" name="active_status" value="1" '.$chkStatus.' /></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="btnsubmit" value="Save" /></td></tr>
		</table>
		<input type="hidden" id="recid" name="recid" value="'.$id.'" />
		';
		
		return $strReturn;
	}
	
	function sentInvoiceMail($toemail)
	{
		
		$objPage = new possale();
		
		$query = mysql_query("SELECT * from crs_client where id='".$toemail."'");
		$userdetails = @mysql_fetch_array($query);		
		$toemail = $userdetails['emailid'];
		
		$invoice_query = mysql_query("SELECT * from crs_invoice_list where client_id='".$toemail."'");
		$user_invoice_details = @mysql_fetch_array(invoice_query);		
		$invoice_file = $user_invoice_details['invoice_file_name'];
		
			//$headers1 = "From: Chennai Rental Systems < info@caltechsoft.com >\r\n";
			//$headers1 .= "Reply-To: Chennai Rental Systems < info@caltechsoft.com >\r\n";
			//$headers1 .= "Return-Path: CRS Support < info@caltechsoft.com >\r\n";
			//$headers .= "CC: susan@example.com\r\n";
			//$headers1 .= "MIME-Version: 1.0\r\n";
			//$headers1 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";	
			
			
			$name        = "Admin";
			$email       = $toemail;
			$to          = "$name <$email>";
			$from        = "From: Chennai Rental Systems < info@caltechsoft.com >\r\n";
			$replyto     = "Replt To: Chennai Rental Systems < info@caltechsoft.com >\r\n";
			$subject     = "Current Month Invoice";
			$mainMessage = "Hi Admin, <br /><br/> Please find the current month invoice. If any other queries please give us a call.<br/><br/> Thanks,<br/>CRS Admin";
			
			$fileatt     = "'.SITE_ROOT .'/invoice/'.$invoice_file.'.pdf";

			$fileatttype = "application/pdf";
			$fileattname = "invoice.pdf";
			
			$headers = "From: Chennai Rental Systems < info@caltechsoft.com >\r\n";
			$headers .= "Reply-To: Chennai Rental Systems < info@caltechsoft.com >\r\n";
			$headers .= "Return-Path: CRS Support < info@caltechsoft.com >\r\n";
		
			 // handles mime type for better receiving
			$ext = strrchr( $fileatt , '.');
			$ftype = "";
			if ($ext == ".doc") $ftype = "application/msword";
			if ($ext == ".jpg") $ftype = "image/jpeg";
			if ($ext == ".gif") $ftype = "image/gif";
			if ($ext == ".zip") $ftype = "application/zip";
			if ($ext == ".pdf") $ftype = "application/pdf";
			if ($ftype=="") $ftype = "application/octet-stream";
			 
			// read file into $data var
			$file = fopen($fileatt, "rb");
			$data = fread($file,  filesize( $fileatt ) );
			fclose($file);
	 
			// split the file into chunks for attaching
			$content = chunk_split(base64_encode($data));
			$uid = md5(uniqid(time()));
	 
			// build the headers for attachment and html
			$h = 'From: $from\r\n';
			if ($replyto) $h .= 'Reply-To: '.$replyto.'\r\n';
			$h .= 'MIME-Version: 1.0\r\n';
			$h .= 'Content-type: multipart/alternative; boundary=' . $uid . '\r\n';
			$h .= 'This is a multi-part message in MIME format.\r\n';
			$h .= '--'.$uid.'\r\n';
			$h .= 'Content-type:text/html; charset=iso-8859-1\r\n';
			$h .= 'Content-Transfer-Encoding: 7bit\r\n\r\n';
			$h .= $mainMessage.'\r\n\r\n';
			$h .= '--'.$uid.'\r\n';
			$h .= 'Content-Type: '.$ftype.'; name=\''.basename($fileatt).'\'\r\n';
			$h .= 'Content-Transfer-Encoding: base64\r\n';
			$h .= 'Content-Disposition: attachment; filename=\''.basename($fileatt).'\'\r\n\r\n';
			$h .= $content.'\r\n\r\n';
			$h .= '--'.$uid.'--';

			// Send the email
			if(mail($to, $subject,strip_tags($messagehtml), str_replace('\r\n','\n',$h))) {

				$msg = "The email was sent.";

			}
			else {

				$msg = "There was an error sending the mail.";

			}
			header("location: index.php?option=com_pos&view=invoice&cid=".$toemail);
		    //$result = mail($toemail, $subject, $message,$headers1);
		
	}
	
	
	function getPaymentForm($id="")
	{
		
		$objPage = new possale();
		
		$userroles  = array("paid","hold","pending","partial");
		
		$strSelect = "<select name='payment_status'><option value=''>--Select--</option>";
		for($j=0;$j<count($userroles);$j++)
		{			
			$selStatus = (@$uDetails['payment_status'] == $userroles[$j]) ? "selected='selected'" : "";
			$strSelect .= "<option value='".$userroles[$j]."' ".$selStatus.">".ucfirst($userroles[$j])."</option>";
		}
		$strSelect .= "</select>";
		
		$strReturn ='
		
		<table>
		<tr><td>Payment Status:</td><td>'.$strSelect.'</td></tr>
		<tr><td>Partial Payment:</td><td><input type="text" name="p_payment" /></td></tr>
				<tr><td>Comments:</td><td><textarea cols="40" rows="8" name="pay_comments"></textarea></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="btnsubmit" value="Save" /></td></tr>
		</table>
		<input type="hidden" id="recid" name="recid" value="'.$id.'" />
		';
		
		return $strReturn;
	}
	
	function getClientForm($id="")
	{
		$objPage = new possale();
		$cDetails = $objPage->getClientDetailsById($id);
		$dDate = ($cDetails['delivery_date']) ? date("d-m-Y",strtotime($cDetails['delivery_date'])) : date("d-m-Y");
		$rDate = ($cDetails['return_date']) ? date("d-m-Y",strtotime($cDetails['return_date'])) : date("d-m-Y");
		
		$strReturn = '<script>$(function() { $( "#dDate" ).datepicker({dateFormat: "dd-mm-yy"}); }); </script>';
		$strReturn .= '<script>$(function() { $( "#rDate" ).datepicker({dateFormat: "dd-mm-yy"}); }); </script>';		
		$strReturn .='
		<table>
		<tr>
		<td colspan="2">Client Name<br /><input type="text" name="txtClientName" class="validate[required] textinputcommon" value="'.@$cDetails['client_name'].'" /></td>
		</tr>
		<tr>
		<td colspan="2">Organisation<br /><input type="text" name="txtOrg" class="validate[required] textinputcommon txtinput" value="'.@$cDetails['organisation'].'" /></td>
		</tr>
		<tr>
		<td>Email Id <br /><input type="text" name="txtEmail" class="validate[required,custom[email]] textinputcommon" value="'.@$cDetails['emailid'].'" /><br />Phone No<br /><input type="text" name="txtPhone" class="validate[required,custom[number]] textinputcommon" value="'.@$cDetails['phoneno'].'" /></td>
		<td>Address<br /><textarea name="txtAddress" class="validate[required] textinputAreacommon">'.@$cDetails['address'].'</textarea></td>
		</tr>
		<tr>
		<td>Delivery Date<br /><input type="text" id="dDate" name="txtDeliveryDate" class="validate[required] textinputcommon" value="'.$dDate.'" /></td>
		<td>Return Date<br /><input type="text" id="rDate" name="txtReturnDate" class="validate[required] textinputcommon" value="'.$dDate.'" /></td>
		</tr>
		<tr><td colspan="2" align="center"><input type="submit" class="btnsubmit" value="Save" /></td></tr>
		</table>
		<input type="hidden" id="recid" name="recid" value="'.$id.'" />
		';
		
		return $strReturn;
	}
	
	function getSystemForm($id="")
	{
		$objPage = new possale();
		$cDetails = $objPage->getSysInfoDetailsById($id);
		
		$rentalCategory = $objPage->getRentalCategory();
		$totCat = count($rentalCategory);		
		
		$catID = @$cDetails['system_type'];
			
		$strCategory = "<select name='txtSysType' id='txtSysType' onchange='changeStyType' class='textinputcommon validate[required]'>";
		for($i=0;$i<$totCat;$i++){
			
			$selected = ($catID == $rentalCategory[$i]['category_meta']) ? "selected = 'selected'" : "";			
			$strCategory .= "<option ".$selected." value='".$rentalCategory[$i]['category_meta']."'>".$rentalCategory[$i]['rental_category']."</option>";
		}
		$strCategory .= "</select>";
		
		$strReturn .='
		<table>
		<tr><td>System Type: '.$strCategory.'		
		
		</td>
		<td>Qty<br /><input type="text" name="txtQty" class="textinputcommon validate[required,custom[integer]]" value="'.@$cDetails['system_qty'].'" /></td></tr>
		<tr><td>Short Description<br /><input type="text" name="txtShortDes" id="txtShortDes" class="textinputcommon validate[required]" value="'.@$cDetails['short_description'].'" /></td>
		<td>Unit Rent<br /><input type="text" name="txtUnitRent" class="textinputcommon validate[required,custom[number]]" value="'.@$cDetails['unit_rent'].'" /></td></tr>
		<tr><td colspan="2">Description<br /><textarea name="txtDes" class="textAreacommon validate[required]">'.@$cDetails['description'].'</textarea></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="btnsubmit" value="Save" /></td></tr>
		</table>
		<input type="hidden" id="recid" name="recid" value="'.$id.'" />
		';
		
		return $strReturn;
	}
	
	
	function getOnOfficeSysForm($id="")
	{
		$objPage = new possale();
		$cDetails = $objPage->getOnOfficeSysById($id);
		
		$rentalCategory = $objPage->getRentalCategory();
		$totCat = count($rentalCategory);		
		
		$catID = @$cDetails['system_type'];
		$available = @$cDetails['available_status'];
			
		$strCategory = "<select name='txtSysType' id='txtSysType' class='textinputcommon validate[required]'>";
		for($i=0;$i<$totCat;$i++){
			
			$selected = ($catID == $rentalCategory[$i]['category_meta']) ? "selected = 'selected'" : "";			
			$strCategory .= "<option ".$selected." value='".$rentalCategory[$i]['category_meta']."'>".$rentalCategory[$i]['rental_category']."</option>";
		}
		$strCategory .= "</select>";
		
		$arrSysAvail = array('yes','no');
		$strSysAvail = "<select name='txtSysAvail' id='txtSysAvail' class='textinputcommon validate[required]'>";
		for($j = 0; $j < count($arrSysAvail); $j++)
		{
			$selStatus = ($arrSysAvail[$j] == $available) ? "selected = 'selected'" : '';
			$strSysAvail .= "<option ".$selStatus." value='".$arrSysAvail[$j]."'>".ucfirst($arrSysAvail[$j])."</option>";
		}
		$strSysAvail .= "</select>";
		
		$strReturn ='
		<table>
		<tr><td>System Type: '.$strCategory.'		
		
		</td>
		<td>Qty<br /><input type="text" name="txtQty" class="textinputcommon validate[required,custom[integer]]" value="'.@$cDetails['system_qty'].'" /></td></tr>
		<tr><td>Short Description<br /><input type="text" name="txtShortDes" class="textinputcommon validate[required]" value="'.@$cDetails['short_description'].'" /></td>
		<td>Available Status<br />'.$strSysAvail.'</td></tr>
		<tr><td colspan="2">Description<br /><textarea name="txtDes" class="textAreacommon validate[required]">'.@$cDetails['description'].'</textarea></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="btnsubmit" value="Save" /></td></tr>
		</table>
		<input type="hidden" id="recid" name="recid" value="'.$id.'" />
		';
		
		return $strReturn;
	}
		
	//check user auth
	public function checkUserAuth()
	{
	    $arrData["txtname"] = @$_SESSION['susername'];
		$arrData["txtpassword"] = @$_SESSION['spassword'];
		$userauth = new userauthentication();
		$stText = $userauth->checkUserLogin($arrData);	
					
		if($stText == "invalid")
		{
			$_SESSION['error_msg'] = "Invalid Login";
			header("location: index.php");
		}				
		
	}
	
	
	public function get_new_order_form()
	{
		$strReturn ='
		<table>
		<tr><td>Client Name:</td><td><input type="text" class="textinputcommon" name="client_name" /></td></tr>
		<tr><td>Contact No:</td><td><input type="text" class="textinputcommon" name="contact_number" /></td></tr>
		<tr><td>Contact Email:</td><td><input type="text" class="textinputcommon" name="contact_email"  /></td></tr>
		<tr><td colspan="2">Requirements</td></tr>
		<tr><td colspan="2"><textarea rows="10" cols="70" name="requirements"></textarea></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="btnsubmit" value="Save" /></td></tr>
		
		</table>
		
		';
		
		return $strReturn;
	}
	
	public function get_new_service_form($id)
	{
		$objPage = new possale();
		$cDetails = $objPage->getServiceDetailsById($id);
		
		$serviceStatus  = array("pending","hold","inprogress","closed");
		
		$strSelect = "<select name='service_status'><option value=''>--Select--</option>";
		for($j=0;$j<count($serviceStatus);$j++)
		{			
			$selStatus = (@$cDetails['service_status'] == $serviceStatus[$j]) ? "selected='selected'" : "";
			$strSelect .= "<option value='".$serviceStatus[$j]."' ".$selStatus.">".ucfirst($serviceStatus[$j])."</option>";
		}
		$strSelect .= "</select>";
		
		if($id){
			$strSelect = '<tr><td>Status:</td><td>'.$strSelect.'</td></tr>	';
		}else{
			$strSelect = '';
		}
		
		$strReturn ='
		<table>
		<tr><td>Client Name:</td><td><input type="text" class="textinputcommon" name="client_name" value="'.@$cDetails['client_name'].'" /></td></tr>
		<tr><td>Client Address:</td><td><input type="text" class="textinputcommon" name="client_address" value="'.@$cDetails['client_address'].'" /></td></tr>
		<tr><td>Contact No:</td><td><input type="text" class="textinputcommon" name="contact_number" value="'.@$cDetails['contact_number'].'" /></td></tr>
		<tr><td>Contact Email:</td><td><input type="text" class="textinputcommon" name="contact_email" value="'.@$cDetails['contact_email'].'"  /></td></tr>
		'.$strSelect.'
		<tr><td colspan="2">Service Comments:</td></tr>
		<tr><td colspan="2"><textarea rows="10" cols="70" name="requirements">'.@$cDetails['service_request'].'</textarea></td></tr>
		<tr><td>Executive name:</td><td><input type="text" class="textinputcommon" name="exe_name" value="'.@$cDetails['exe_name'].'" /></td></tr>
		<tr><td>Executive Email:</td><td><input type="text" class="textinputcommon" name="exe_email" value="'.@$cDetails['exe_email'].'" /></td></tr>
		<tr><td colspan="2" align="center"><input type="hidden" name="rid" value="'.$id.'" /><input type="submit" class="btnsubmit" value="Save"  /></td></tr>
		
		</table>
		
		';
		
		return $strReturn;
	}
	
	
	public function builddropdown($arrBuildData)
	{		
		$arrOptData = $arrBuildData['optiondata'];
		$strReturnText = "";		
		$strReturnText = "<select name='".$arrBuildData['name']."'>";
		for($i=0;$i<count($arrOptData);$i++){
			$strReturnText .= "<option value='".$arrOptData[$i]."'>".$arrOptData[$i]."</option>";
		}
		$strReturnText .= "</select>";
		return $strReturnText;
	}
	
	public function get_new_account_form($id)
	{
		$objPage = new possale();
		$cDetails = $objPage->getAccountDetailsById($id);
		
		if(isset($cDetails['expense_date'])){
			$exp_date = $cDetails['expense_date'];			
		}else{
			$exp_date = date("Y-m-d");			
		}
		
		$arrSysAvail = array("rentalincome","general");
		$strExpensType = "<select name='expense_type' id='expense_type' class='textinputcommon validate[required]'>";
		for($j = 0; $j < count($arrSysAvail); $j++)
		{
			$selStatus = ($arrSysAvail[$j] == $cDetails['expense_type']) ? "selected = 'selected'" : '';
			$strExpensType .= "<option ".$selStatus." value='".$arrSysAvail[$j]."'>".ucfirst($arrSysAvail[$j])."</option>";
		}
		$strExpensType .= "</select>";
		
		$arrSysAvailNew = array("credit","debit");
		$strEntryType = "<select name='cash_type' id='cash_type' class='textinputcommon validate[required]'>";
		for($j = 0; $j < count($arrSysAvailNew); $j++)
		{
			$selStatusNew = ($arrSysAvailNew[$j] == $cDetails['cash_type']) ? "selected = 'selected'" : '';
			$strEntryType .= "<option ".$selStatusNew." value='".$arrSysAvailNew[$j]."'>".ucfirst($arrSysAvailNew[$j])."</option>";
		}
		$strEntryType .= "</select>";

		
		//$arrEntryData = array("credit","debit");
		//$arrbuidldrop['optiondata'] = array("credit","debit");
		//$arrbuidldrop['name'] = "cash_type";
		//$strEntryType = $this->builddropdown($arrbuidldrop);
		
		$arrSysAvailOne = array("cash","cheque");
		$strPaymentType = "<select name='payment_type' id='payment_type' class='textinputcommon validate[required]'>";
		for($j = 0; $j < count($arrSysAvailOne); $j++)
		{
			$selStatusOne = ($arrSysAvailOne[$j] == $cDetails['payment_type']) ? "selected = 'selected'" : '';
			$strPaymentType .= "<option ".$selStatusOne." value='".$arrSysAvailOne[$j]."'>".ucfirst($arrSysAvailOne[$j])."</option>";
		}
		$strPaymentType .= "</select>";
		
		
		//arrbuidldrop['optiondata'] = array("cash","cheque");
		//$arrbuidldrop['name'] = "payment_type";
		//$strPaymentType = $this->builddropdown($arrbuidldrop);
		
		//$arrbuidldrop['optiondata'] = array("rentalincome","general");
		//$arrbuidldrop['name'] = "expense_type";
		//$strExpensType = $this->builddropdown($arrbuidldrop);
		
		$strReturn ='
		<table>	
		<tr><td>Entry Date:</td><td><input type="text" class="textinputcommon" name="expense_date" value="'.$exp_date.'" /></td></tr>
		<tr><td>Entry Type</td><td>'.$strExpensType.'</td></tr>
		<tr><td>Entry Category</td><td>'.$strEntryType.'</td></tr>
		<tr><td>Description:</td><td><input type="text" class="textinputcommon" name="description" value="'.$cDetails['description'].'" /></td></tr>
		<tr><td>Payment Type</td><td>'.$strPaymentType.'</td></tr>	
		<tr><td>Amount:</td><td><input type="text" class="textinputcommon" name="entry_amount" value="'.$cDetails['entry_amount'].'" /></td></tr>	
		<tr><td>Voucher / Cheque No:</td><td><input type="text" class="textinputcommon" name="voucher_no" value="'.$cDetails['voucher_no'].'" /></td></tr>
		<tr><td>Person:</td><td><input type="text" class="textinputcommon" name="voucher_person" value="'.$cDetails['voucher_person'].'" /></td></tr>
		<tr><td colspan="2">Payment Remarks</td></tr>
		<tr><td colspan="2"><textarea rows="10" cols="70" name="payment_remarks">'.$cDetails['payment_remarks'].'</textarea></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="btnsubmit" value="Save" /></td></tr>
		
		</table>
		<input type="hidden" name="id" value="'.$id.'" />
		';
		
		return $strReturn;
	}
	
	public function get_new_cheque_form($id)
	{
		$objPage = new possale();
		$cDetails = $objPage->getChequeDetailsById($id);
		
		if(isset($cDetails['cheque_date'])){
			$exp_date = $cDetails['cheque_date'];			
		}else{
			$exp_date = date("Y-m-d");			
		}
		
		$arrSysAvail = array("rentalincome","general");
		$strExpensType = "<select name='expense_type' id='expense_type' class='textinputcommon validate[required]'>";
		for($j = 0; $j < count($arrSysAvail); $j++)
		{
			$selStatus = ($arrSysAvail[$j] == $cDetails['expense_type']) ? "selected = 'selected'" : '';
			$strExpensType .= "<option ".$selStatus." value='".$arrSysAvail[$j]."'>".ucfirst($arrSysAvail[$j])."</option>";
		}
		$strExpensType .= "</select>";
		
		$arrSysAvailNew = array("credit");
		$strEntryType = "<select name='cash_type' id='cash_type' class='textinputcommon validate[required]'>";
		for($j = 0; $j < count($arrSysAvailNew); $j++)
		{
			$selStatusNew = ($arrSysAvailNew[$j] == $cDetails['cash_type']) ? "selected = 'selected'" : '';
			$strEntryType .= "<option ".$selStatusNew." value='".$arrSysAvailNew[$j]."'>".ucfirst($arrSysAvailNew[$j])."</option>";
		}
		$strEntryType .= "</select>";

		
		//$arrEntryData = array("credit","debit");
		//$arrbuidldrop['optiondata'] = array("credit","debit");
		//$arrbuidldrop['name'] = "cash_type";
		//$strEntryType = $this->builddropdown($arrbuidldrop);
		
		$arrSysAvailOne = array("cheque");
		$strPaymentType = "<select name='payment_type' id='payment_type' class='textinputcommon validate[required]'>";
		for($j = 0; $j < count($arrSysAvailOne); $j++)
		{
			$selStatusOne = ($arrSysAvailOne[$j] == $cDetails['payment_type']) ? "selected = 'selected'" : '';
			$strPaymentType .= "<option ".$selStatusOne." value='".$arrSysAvailOne[$j]."'>".ucfirst($arrSysAvailOne[$j])."</option>";
		}
		$strPaymentType .= "</select>";
		
		$arrSysAvailPay = array("dropped","credited","bounce");
		$strPaymentStatus = "<select name='payment_status' id='payment_status' class='textinputcommon validate[required]'>";
		for($j = 0; $j < count($arrSysAvailPay); $j++)
		{
			$selPStatusOne = ($arrSysAvailPay[$j] == $cDetails['payment_status']) ? "selected = 'selected'" : '';
			$strPaymentStatus .= "<option ".$selPStatusOne." value='".$arrSysAvailPay[$j]."'>".ucfirst($arrSysAvailPay[$j])."</option>";
		}
		$strPaymentStatus .= "</select>";
		
		
		//arrbuidldrop['optiondata'] = array("cash","cheque");
		//$arrbuidldrop['name'] = "payment_type";
		//$strPaymentType = $this->builddropdown($arrbuidldrop);
		
		//$arrbuidldrop['optiondata'] = array("rentalincome","general");
		//$arrbuidldrop['name'] = "expense_type";
		//$strExpensType = $this->builddropdown($arrbuidldrop);
		
		$strReturn ='
		<table>	
		<tr><td>Cheque Date:</td><td><input type="text" class="textinputcommon" name="cheque_date" value="'.$exp_date.'" /></td></tr>
		<tr><td>Income Type</td><td>'.$strExpensType.'</td></tr>
		<tr><td>Client Name:</td><td><input type="text" class="textinputcommon" name="client_name" value="'.$cDetails['client_name'].'" /></td></tr>
		<tr><td>Bank Name:</td><td><input type="text" class="textinputcommon" name="bank_name" value="'.$cDetails['bank_name'].'" /></td></tr>
		<tr><td>Payment Type:</td><td>'.$strPaymentType.'</td></tr>	
		<tr><td>Payment Status:</td><td>'.$strPaymentStatus.'</td></tr>
		<tr><td>Amount:</td><td><input type="text" class="textinputcommon" name="entry_amount" value="'.$cDetails['entry_amount'].'" /></td></tr>	
		<tr><td>Cheque No:</td><td><input type="text" class="textinputcommon" name="cheque_no" value="'.$cDetails['cheque_no'].'" /></td></tr>
		<tr><td>Collected By:</td><td><input type="text" class="textinputcommon" name="cheque_person" value="'.$cDetails['cheque_person'].'" /></td></tr>
		<tr><td colspan="2">Payment Remarks</td></tr>
		<tr><td colspan="2"><textarea rows="10" cols="70" name="payment_remarks">'.$cDetails['payment_remarks'].'</textarea></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="btnsubmit" value="Save" /></td></tr>
		
		</table>
		<input type="hidden" name="id" value="'.$id.'" />
		';
		
		return $strReturn;
	}
	
	public function get_new_service_account_form($id)
	{
		$objPage = new possale();
		$cDetails = $objPage->getServiceAccountDetailsById($id);
		
		if(isset($cDetails['expense_date'])){
			$exp_date = $cDetails['expense_date'];			
		}else{
			$exp_date = date("Y-m-d");			
		}
		
		$arrSysAvail = array("serviceincome","general");
		$strExpensType = "<select name='expense_type' id='expense_type' class='textinputcommon validate[required]'>";
		for($j = 0; $j < count($arrSysAvail); $j++)
		{
			$selStatus = ($arrSysAvail[$j] == $cDetails['expense_type']) ? "selected = 'selected'" : '';
			$strExpensType .= "<option ".$selStatus." value='".$arrSysAvail[$j]."'>".ucfirst($arrSysAvail[$j])."</option>";
		}
		$strExpensType .= "</select>";
		
		$arrSysAvailNew = array("credit","debit");
		$strEntryType = "<select name='cash_type' id='cash_type' class='textinputcommon validate[required]'>";
		for($j = 0; $j < count($arrSysAvailNew); $j++)
		{
			$selStatusNew = ($arrSysAvailNew[$j] == $cDetails['cash_type']) ? "selected = 'selected'" : '';
			$strEntryType .= "<option ".$selStatusNew." value='".$arrSysAvailNew[$j]."'>".ucfirst($arrSysAvailNew[$j])."</option>";
		}
		$strEntryType .= "</select>";

		
		//$arrEntryData = array("credit","debit");
		//$arrbuidldrop['optiondata'] = array("credit","debit");
		//$arrbuidldrop['name'] = "cash_type";
		//$strEntryType = $this->builddropdown($arrbuidldrop);
		
		$arrSysAvailOne = array("cash","cheque");
		$strPaymentType = "<select name='payment_type' id='payment_type' class='textinputcommon validate[required]'>";
		for($j = 0; $j < count($arrSysAvailOne); $j++)
		{
			$selStatusOne = ($arrSysAvailOne[$j] == $cDetails['payment_type']) ? "selected = 'selected'" : '';
			$strPaymentType .= "<option ".$selStatusOne." value='".$arrSysAvailOne[$j]."'>".ucfirst($arrSysAvailOne[$j])."</option>";
		}
		$strPaymentType .= "</select>";
		
		
		//arrbuidldrop['optiondata'] = array("cash","cheque");
		//$arrbuidldrop['name'] = "payment_type";
		//$strPaymentType = $this->builddropdown($arrbuidldrop);
		
		//$arrbuidldrop['optiondata'] = array("rentalincome","general");
		//$arrbuidldrop['name'] = "expense_type";
		//$strExpensType = $this->builddropdown($arrbuidldrop);
		
		$strReturn ='
		<table>	
		<tr><td>Entry Date:</td><td><input type="text" class="textinputcommon" name="expense_date" value="'.$exp_date.'" /></td></tr>
		<tr><td>Entry Type</td><td>'.$strExpensType.'</td></tr>
		<tr><td>Entry Category</td><td>'.$strEntryType.'</td></tr>
		<tr><td>Description:</td><td><input type="text" class="textinputcommon" name="description" value="'.$cDetails['description'].'" /></td></tr>
		<tr><td>Payment Type</td><td>'.$strPaymentType.'</td></tr>	
		<tr><td>Amount:</td><td><input type="text" class="textinputcommon" name="entry_amount" value="'.$cDetails['entry_amount'].'" /></td></tr>	
		<tr><td>Voucher / Cheque No:</td><td><input type="text" class="textinputcommon" name="voucher_no" value="'.$cDetails['voucher_no'].'" /></td></tr>
		<tr><td>Person:</td><td><input type="text" class="textinputcommon" name="voucher_person" value="'.$cDetails['voucher_person'].'" /></td></tr>
		<tr><td colspan="2">Payment Remarks</td></tr>
		<tr><td colspan="2"><textarea rows="10" cols="70" name="payment_remarks">'.$cDetails['payment_remarks'].'</textarea></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="btnsubmit" value="Save" /></td></tr>
		
		</table>
		<input type="hidden" name="id" value="'.$id.'" />
		';
		
		return $strReturn;
	}
	
}

?>