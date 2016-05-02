<?php

include_once(SERVER_ROOT . '/lib/dmlib.php');
include_once(SERVER_ROOT . '/lib/emailcontents.php');
include_once(SERVER_ROOT . '/lib/imagehandler.php');
require_once(SERVER_ROOT . '/lib/tcpdf/tcpdf_config_alt.php');
require_once(SERVER_ROOT . '/lib/tcpdf/tcpdf.php');

class possale {



	public function getUserDetailsByID($id)
	{
		$query = mysql_query("SELECT * from mpb_users where id='".$id."'");
		$userdetails = @mysql_fetch_array($query);
		return @$userdetails;	
	}

	public function getUserReferences($userId)
	{	
	$db = new dbquery();
	$query = mysql_query("SELECT * from mpb_user_references where user_id='".$userId."'");
	while ($row = mysql_fetch_assoc($query)) {
		$references[] =  $row;
	}
	 return $references;
	}
	
	public function deleteRecordById($table,$id)
	{
		$db = new dbquery();
		$db->delete_record_by_id($table,$id);
	}
	
	public function moveDataToTrash($arrData)
	{
		$db = new dbquery();		
		
		//move to trash
		$arrTrashData['table_name'] = $arrData['table_name'];
		$arrTrashData['record_id'] = $arrData['record_id'];
		$db->insert_table($arrTrashData,TBL_PREFIX.'trash_data');
		
		//update deleted status
		$arrUpdateData['trash_status'] = "1";
		$db->update_table($arrUpdateData,TBL_PREFIX.$arrTrashData['table_name'],$arrTrashData['record_id']);
	}
	
	public function updateTableByTable($table,$arrData,$id)
	{
		$db = new dbquery();
		$db->update_table($arrData,TBL_PREFIX.$table,$id);
	}
	
	public function getCountRecords($tbl,$cntfield="*",$extraSql="")
	{
		$extraSql = ($extraSql) ? " where ".$extraSql : "";		
		$query = mysql_query("SELECT count(".$cntfield.") as totCount from ".TBL_PREFIX.$tbl.$extraSql);
		$buildingDetails = @mysql_fetch_array($query);
		return @$buildingDetails['totCount'];
	}
	
	public function insertUpdateUser($arrData)
	{		
		$db = new dbquery();
		
		$arrData['profile_type'] = $_SESSION['sprofile'];
		
		if(@$arrData['recid'])
		{	
			if($arrData['userpasswords'])
			{
				$arrData['userpassword'] = md5($arrData['userpasswords']);
			}
		    $uid = $arrData['recid'];	
			unset($arrData['recid']);	
			$db->update_table($arrData,TBL_PREFIX.'admin_users',$uid );
		}
		else
		{
			$arrData['userpassword'] = md5($arrData['userpasswords']);
			$db->insert_table($arrData,TBL_PREFIX.'admin_users');
		}		
	}
	
	public function uploaddoc($arrData)
	{		
		$db = new dbquery();
		
		//print_r($arrData);die;
		if($_FILES["fileDoc"]["name"])
		{
			$originalname = $_FILES["fileDoc"]["name"];
			$extension = explode('.', $_FILES['fileDoc']['name']);
			$filename = "document_".$arrData['cID']."_".date("dmYHis").".".end($extension);
			if(move_uploaded_file($_FILES["fileDoc"]["tmp_name"],SERVER_ROOT."/documents/$filename"))
			{
				$arrInsert['client_id'] = $arrData['cID'];
				$arrInsert['document_name'] = $filename;
				$arrInsert['document_type'] = $arrData['txtdocType'];
				$arrInsert['updated_date'] = date("Y-m-d H:i:s");
				$db->insert_table($arrInsert,TBL_PREFIX.'client_document');
			}
		}
	}
	
	public function updatePaymentStatusInfo($arrData)
	{		

		$db = new dbquery();
		
		if($arrData['cId'] != ''){
			$query = mysql_query("SELECT * from ".TBL_PREFIX."invoice_list where client_id='".$arrData['cId']."' and archive_status='0'");
		}else{
			$query = mysql_query("SELECT * from ".TBL_PREFIX."invoice_list where id='".$arrData['rId']."'  and archive_status='0'");
		}

		$clientDetails = @mysql_fetch_assoc($query);
		
		//Update Invoice table
		$arrUpdate['payment_status'] = $arrData['payment_status'];
		
		
		if($arrData['p_payment']){
			$arrUpdate['partial_amount'] = $arrData['p_payment']+$clientDetails['partial_amount'];
		}else{
			$arrUpdate['partial_amount'] = 0;
		}
		
		$arrUpdate['id'] = $clientDetails['id'];		
	
		$db->update_table($arrUpdate,TBL_PREFIX.'invoice_list',$clientDetails['id'] );
		
		if($arrData['cId'] != ''){
			$clientDetails['client_id'] = $clientDetails['client_id'];			
		}else{
			$clientDetails['client_id'] = $clientDetails['id'];
		}
		
		//Insert comments table
		$arrInsert['user_id'] = $clientDetails['client_id'];
		$arrInsert['invoice_id'] = $clientDetails['id'];
		$arrInsert['pay_status'] = $arrData['payment_status'];
		$arrInsert['pay_comments'] = $arrData['pay_comments'];
		$arrInsert['date'] =  date("Y-m-d H:i:s");

		$turn_rec = $db->insert_table($arrInsert,TBL_PREFIX.'payment_comments');
		
	}
	
	public function updateDocStatus($arrData)
	{		
		$db = new dbquery();
		$arrUpdate['verifiedby'] = $arrData['txtVerified'];
		$arrUpdate['verified_date'] = date("Y-m-d H:i:s");
		$rId = $arrData['recId'];
		$db->update_table($arrUpdate,TBL_PREFIX.'client_document',$rId );
	}
	
	public function insertUpdateClient($arrData)
	{		
		$db = new dbquery();
		
		//print_r($arrData);die;
		$arrInsert['client_id'] = $arrData['txtClientId'];
		$arrInsert['client_name'] = $arrData['txtClientName'];
		$arrInsert['organisation'] = $arrData['txtOrg'];
		$arrInsert['emailid'] = $arrData['txtEmail'];
		$arrInsert['mobileno'] = $arrData['txtMobile'];
		$arrInsert['landline'] = $arrData['txtLandLine'];
		$arrInsert['address'] = $arrData['txtAddress'];
		$arrInsert['contact_person'] = $arrData['txtContactPerson'];
		$arrInsert['cemailid'] = $arrData['txtcEmail'];
		$arrInsert['cmobileno'] = $arrData['txtcMobile'];
		$arrInsert['profile_type'] = $_SESSION['sprofile'];
		$arrInsert['start_date'] = date("Y-m-d H:i:s",strtotime($arrData['txtDeliveryDate']));
		$arrInsert['end_date'] = date("Y-m-d H:i:s",strtotime($arrData['txtReturnDate']));
		$arrInsert['invoice_date'] = $arrData['selInvoiceDate'];
		$arrInsert['comments'] = $arrData['txtComments'];
		$arrInsert['duration_type'] = $arrData['selDurationType'];
		$arrInsert['duration'] = $arrData['selDuration'];
		$arrInsert['total_systems'] = $arrData['txtTotSys'];
		$arrInsert['deposit_months'] = $arrData['txtDepositmonths'];
		$arrInsert['deposit_amount'] = $arrData['txtDepositAmount'];
		$arrInsert['num_cheque'] = $arrData['txtnCheque'];
		$arrInsert['total_cheque_amount'] = $arrData['txtcAmount'];
		
		if(@$arrData['recid'] > 0)
		{	
		   $cid = $arrData['recid'];	
			unset($arrData['recid']);	
			$db->update_table($arrInsert,TBL_PREFIX.'client',$cid );
		}
		else
		{
			$db->insert_table($arrInsert,TBL_PREFIX.'client');
		}		
	}
	
	public function insertUpdateSysInfo($arrData)
	{		
		$db = new dbquery();
		
		//print_r($arrData);die;
		$arrInsert['client_id'] = $arrData['cId'];
		$arrInsert['system_type'] = $arrData['txtSysType'];
		$arrInsert['short_description'] = $arrData['txtShortDes'];
		$arrInsert['description'] = $arrData['txtDes'];
		$arrInsert['system_qty'] = $arrData['txtQty'];
		$arrInsert['unit_rent'] = $arrData['txtUnitRent'];
		$arrInsert['last_update_date'] = date("Y-m-d H:i:s");
		$arrInsert['profile_type'] = $_SESSION['sprofile'];
		$arrInsert['total_amount'] = $arrData['txtUnitRent'] * $arrData['txtQty'];
		$arrInsert['rental_vendor'] = $arrData['txtSysVendor'];
				
		if(@$arrData['recid'] > 0)
		{	
		   $sid = $arrData['recid'];	
			unset($arrData['recid']);	
			$db->update_table($arrInsert,TBL_PREFIX.'system_details',$sid );
		}
		else
		{
			$db->insert_table($arrInsert,TBL_PREFIX.'system_details');
		}		
	}
	
	public function saveOnofficeSys($arrData)
	{		
		$db = new dbquery();
		
		//print_r($arrData);die;
		$arrInsert['system_type'] = $arrData['txtSysType'];
		$arrInsert['short_description'] = $arrData['txtShortDes'];
		$arrInsert['description'] = $arrData['txtDes'];
		$arrInsert['system_qty'] = $arrData['txtQty'];
		$arrInsert['last_update_date'] = date("Y-m-d H:i:s");
		$arrInsert['available_status'] = $arrData['txtSysAvail'];
		$arrInsert['profile_type'] = $_SESSION['sprofile'];
		
		if(@$arrData['recid'] > 0)
		{	
		    $sid = $arrData['recid'];	
			unset($arrData['recid']);	
			$db->update_table($arrInsert,TBL_PREFIX.'onoffice_systems',$sid );
		}
		else
		{
			$db->insert_table($arrInsert,TBL_PREFIX.'onoffice_systems');
		}		
	}
	
	public function getUsersLists($extrasql = "")
	{	
		$extrasql = ($extrasql) ? " and ".$extrasql : "";
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."admin_users where profile_type=".$_SESSION['sprofile']." and trash_status = 0 ".$extrasql);
		while ($row = mysql_fetch_assoc($query)) {
			$userlists[] =  $row;
		}
		return $userlists;
	}
	
	public function getRentalCategory()
	{	
		
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."rental_category ");
		while ($row = mysql_fetch_assoc($query)) {
			$rentalcategory[] =  $row;
		}
		return $rentalcategory;
	}
	
	
	public function getClientsLists($extrasql = "")
	{	
		$extrasql = ($extrasql) ? " and ".$extrasql : "";
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."client where profile_type='".$_SESSION['sprofile']."' and active ='yes' and trash_status = 0 ".$extrasql);
		while ($row = mysql_fetch_assoc($query)) {
			$clientlists[] =  $row;
		}
		return @$clientlists;
	}
	
	public function getClientSysDetails($id,$extrasql = "")
	{	
		$extrasql = ($extrasql) ? " and ".$extrasql : "";
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."system_details where client_id='".$id."' and profile_type='".$_SESSION['sprofile']."' and trash_status = 0 ".$extrasql);
		while ($row = mysql_fetch_assoc($query)) {
			$clientlists[] =  $row;
		}
		return $clientlists;
	}
	
	public function getOnofficeSys($extrasql = "")
	{	
		$extrasql = ($extrasql) ? " and ".$extrasql : "";
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."onoffice_systems where profile_type='".$_SESSION['sprofile']."' and trash_status = 0 ".$extrasql);
		while ($row = mysql_fetch_assoc($query)) {
			$clientlists[] =  $row;
		}
		return $clientlists;
	}
	
	public function getPaymentComments($extrasql = "")
	{	
		$extrasql = ($extrasql) ? $extrasql : "";
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."payment_comments where ".$extrasql);
		while ($row = mysql_fetch_assoc($query)) {
			$clientlists[] =  $row;
		}
		return $clientlists;
	}
	
	public function getSysInfoDetailsById($id)
	{		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."system_details where id='".$id."' and profile_type='".$_SESSION['sprofile']."'");
		$clientlists = @mysql_fetch_array($query);
		return @$clientlists;
	}
	
	public function getOnOfficeSysById($id)
	{		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."onoffice_systems where id='".$id."' and profile_type='".$_SESSION['sprofile']."'");
		$clientlists = @mysql_fetch_array($query);
		return @$clientlists;
	}
	
	public function getInvoiceDetById($id,$invDate)
	{	
		$query = mysql_query("SELECT * from ".TBL_PREFIX."invoice_list where client_id='".$id."' AND invoice_date='".$invDate."' AND profile_type='".$_SESSION['sprofile']."' ORDER BY id DESC limit 1");
		$invoicedet = @mysql_fetch_array($query);
		return @$invoicedet;
	}
	
	public function generateClientId()
	{		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."client where profile_type='".$_SESSION['sprofile']."' ORDER BY id DESC LIMIT 1");
		$clientlists = @mysql_fetch_array($query);
		if($_SESSION['sprofile'] == 1)
		{
			$strId = explode("CRS",$clientlists['client_id']);
			$strTxt = "CRS";
		}
		else if($_SESSION['sprofile'] == 2)
		{
			$strId = explode("BS",$clientlists['client_id']);
			$strTxt = "BS";
		}
		//print_r($strId);
		$strNext = (@$strId[1] + 1);
		$strCid = $strTxt.sprintf("%04d", $strNext);
		return @$strCid;
	}
	
	public function getAdminUserDetailsById($id)
	{		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."admin_users where id='".$id."'");
		$userDetails = @mysql_fetch_array($query);
		return @$userDetails;
	}
	
	public function getClientDetailsById($id)
	{		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."client where id='".$id."'");
		$clientDetails = @mysql_fetch_array($query);
		return @$clientDetails;
	}
	
	public function getServiceDetailsById($id)
	{		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."new_service where id='".$id."'");
		$clientDetails = @mysql_fetch_array($query);
		return @$clientDetails;
	}
	
	public function getAccountDetailsById($id)
	{		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."account_managment where id='".$id."'");
		$clientDetails = @mysql_fetch_array($query);
		return @$clientDetails;
	}
	
	public function getChequeDetailsById($id)
	{		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."account_cheque_details where id='".$id."'");
		$clientDetails = @mysql_fetch_array($query);
		return @$clientDetails;
	}
	
	public function getServiceAccountDetailsById($id)
	{		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."account_managment_service where id='".$id."'");
		$clientDetails = @mysql_fetch_array($query);
		return @$clientDetails;
	}
	
	public function getDocumentDet($id)
	{	
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."client_document where client_id='".$id."' ");
		while ($row = mysql_fetch_assoc($query)) {
		$getDocumenteList[] =  $row;
		}
		return $getDocumenteList;
	}
	
	public function getContactUsLists()
	{	
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."contactus order by id DESC LIMIT 5");
		while ($row = mysql_fetch_assoc($query)) {
		$locations[] =  $row;
		}
		return $locations;
	}
	
	public function getBuildingContactLists()
	{	
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."bulidings_contact order by id DESC LIMIT 5");
		while ($row = mysql_fetch_assoc($query)) {
		$locations[] =  $row;
		}
		return $locations;
	}

	public function getEmailDetails($extrasql = "")
	{	
		$extrasql = ($extrasql) ? $extrasql : "";
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".$extrasql);
		$check_res = @mysql_fetch_array($query);
	  	return $check_res;
	}
	
	public function getRecordsByCustomQuery($tblName,$field="*",$extraSql)
	{	
		$db = new dbquery();
		$extraSql = ($extraSql) ? " where ".$extraSql: "";		
		$query = mysql_query("SELECT ".$field." from ".TBL_PREFIX.$tblName.$extraSql);
		while ($row = mysql_fetch_assoc($query)) {
			$recordsets[] =  $row;
		}
		return $recordsets;
	}
	
	public function getRecordByCustomQuery($tblName,$field="*",$extraSql)
	{		
		$extraSql = ($extraSql) ? " and ".$extraSql: "";	
		$query = mysql_query("SELECT ".$field." from ".TBL_PREFIX.$tblName." where profile_type='".$_SESSION['sprofile']."' ".$extraSql);		
		$recordset = @mysql_fetch_array($query);
		return @$recordset;
	}
	
	public function getRecordByServiceTotal($field="*",$extraSql)
	{		
		$extraSql = ($extraSql) ? $extraSql: "";	
		$query = mysql_query("SELECT ".$field." from ".TBL_PREFIX."account_managment_service where ".$extraSql);		
		$recordset = @mysql_fetch_array($query);
		return @$recordset;
	}
	
	public function getInvoiceLists($extrasql = "")
	{	
		$extrasql = ($extrasql) ? " and ".$extrasql : "";
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."invoice_list where archive_status='0' and profile_type='".$_SESSION['sprofile']."' ".$extrasql." order by payment_status='pending' DESC");
				
		
		while ($row = mysql_fetch_assoc($query)) {
			$invoicelists[] =  $row;
		}
		return $invoicelists;
	}
	
	public function saveInvoice($arrData)
	{	
		$db = new dbquery();
		$arrData['profile_type'] = $_SESSION['sprofile'];
		$db->insert_table($arrData,TBL_PREFIX.'invoice_list');
	}
	
	
	public function insertUpdateNewLeads($arrData)
	{		
		$db = new dbquery();
		
		$arrData['enquiry_date'] = date("Y-m-d H:i:s");
		$db->insert_table($arrData,TBL_PREFIX.'new_leads');
	}
	
	public function insertUpdateNewServices($arrData)
	{		
		$db = new dbquery();

		if($arrData['rid'] != '0'){
			$arrUpdate['client_name'] = $arrData['client_name'];
			$arrUpdate['client_address'] = $arrData['client_address'];
			$arrUpdate['contact_number'] = $arrData['contact_number'];
			$arrUpdate['contact_email'] = $arrData['contact_email'];
			$arrUpdate['service_request'] = $arrData['requirements'];
			$arrUpdate['service_status'] = $arrData['service_status'];
			$arrUpdate['exe_email'] = $arrData['exe_email'];
			$arrUpdate['exe_name'] = $arrData['exe_name'];		
			$arrUpdate['enquiry_date'] = date("Y-m-d H:i:s");
			
			$db->update_table($arrUpdate,TBL_PREFIX.'new_service',$arrData['rid']);
			
		}else{
			$arrInsert['client_name'] = $arrData['client_name'];
			$arrInsert['client_address'] = $arrData['client_address'];
			$arrInsert['contact_number'] = $arrData['contact_number'];
			$arrInsert['contact_email'] = $arrData['contact_email'];
			$arrInsert['service_request'] = $arrData['requirements'];
			$arrInsert['service_status'] = 'pending';
			$arrInsert['exe_email'] = $arrData['exe_email'];
			$arrInsert['exe_name'] = $arrData['exe_name'];
		
			$arrInsert['enquiry_date'] = date("Y-m-d H:i:s");
			$db->insert_table($arrInsert,TBL_PREFIX.'new_service');
		}
		
		
	}
	
	public function getLeadLists($extrasql = "")
	{	
		$extrasql = ($extrasql) ? " and ".$extrasql : "";
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."new_leads where archive_status='0' ".$extrasql);
		while ($row = mysql_fetch_assoc($query)) {
			$leadLists[] =  $row;
		}
		return $leadLists;
	}
	
	public function getServiceLists($extrasql = "")
	{	
		$extrasql = ($extrasql) ? " and ".$extrasql : "";
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."new_service where archive_status='0'".$extrasql);
		while ($row = mysql_fetch_assoc($query)) {
			$leadLists[] =  $row;
		}
		return $leadLists;
	}
	
	public function generateNewInvoiceDocument($arrData,$format="html")
	{
		
		$returntext = "";
		$totSystem = ($arrData['tot_system']) ? $arrData['tot_system'] : 0;
		
		for($i=1;$i<=$totSystem;$i++)
		{
			$description = $arrData['sys_desc_'.$i];
			$unitPrice = $arrData['sys_unit_price_'.$i];
			
			
		  $strDec = $arrData['sys_desc_'.$i];
		  $strUnitRent = $arrData['sys_unit_price_'.$i];
		  $strQty = $arrData['sys_unit_'.$i];
		  $strSubTot = ($strUnitRent * $strQty);
		  $strTotal = $strTotal + $strSubTot;
		  
		  $subTable .='<tr><td width="40px" align="center" style="border-right:1px solid #000;">'.($i + 1).'</td><td width="293px" align="center" style="border-right:1px solid #000;">'.$strDec.'</td><td width="50px" align="center" style="border-right:1px solid #000;">'.$strQty.'</td><td width="125px" align="right" style="border-right:1px solid #000;">&#8377;&nbsp;'.number_format($strUnitRent,2).'</td><td width="130px" align="right">&#8377;&nbsp;'.number_format($strSubTot,2).'</td></tr>';
			
			
		}
		
		  if($arrCount < 20)
		  {
		  $arrCountEmpty = 20 - $arrCount;
		  for($k=0; $k<$arrCountEmpty; $k++)
		  {
		  $subTable .='<tr><td width="40px" align="center" style="border-right:1px solid #000;">&nbsp;</td><td width="293px" align="center" style="border-right:1px solid #000;">&nbsp;</td><td width="50px" align="center" style="border-right:1px solid #000;">&nbsp;</td><td width="125px" align="right" style="border-right:1px solid #000;">&nbsp;</td><td width="130px" align="right">&nbsp;</td></tr>';
		  }
		  }
		  
		  $m = date('M');
		  $y = date('Y');
		  $d = date('d');
		  
		  $strInvDate = $d.'-'.$m.'-'.$y;
		  $strInvNo = "CRS" .substr(md5(rand()), 0, 6);
		
				
		$strMainTable = '<table width="100%" style="border-collapse:collapse; border:1px solid #000;">
		  <tr>
		  <td colspan="5" style="border-bottom:1px solid #000;">
		  <table width="100%">
		  <tr>
		  <td align="center" rowspan="5" style="width:100px;"><img src="'.SITE_ROOT.'/templates/mblue/images/logo.jpg" alt="crs" width="100" height="100" border="0" /></td><td>&nbsp;</td></tr>
		  <tr><td align="right" style="color:#e00c21; width:"600px";">Caltech Soft Pvt Ltd</td></tr>
		  <tr><td align="right" style="width:"600px";"><span style="color:#58D3F7;">No:</span> 10/22, Thiruvalluvar 3<span style="vertical-align:super">rd</span> Street, Adambakkam, Chennai - 600088</td></tr>
		  <tr><td align="right"><span style="color:#58D3F7;">Phone No:</span> 044 22450151</td></tr>
		  <tr><td align="right"><span style="color:#58D3F7;">Email:</span> <a style="text-decoration:none;" href="mailto:info@caltechsoft.com">info@caltechsoft.com</a>, <span style="color:#58D3F7;">Website:</span> <a style="text-decoration:none;" href="www.caltechsoft.com" target="_blank">www.caltechsoft.com</a></td>
		  </tr></table>
		  </td></tr>
		  <tr>
		  <td colspan="3" style="border:1px solid #000;">
		  <table>
		  <tr><td width="100px"><b>Bill To</b></td><td><b>'.$arrData['billto'].'</b></td></tr>
		  <tr><td valign="top"><b>Address</b></td><td>'.$arrData['billtoaddress'].'</td></tr>
		  <tr><td><b>Contact No</b></td><td>'.$arrData['billcontactno'].'</td></tr>
		  <tr><td><b>Email-Id</b></td><td>'.$arrData['billemail'].'</td></tr>
		  </table>
		  </td>
		  <td colspan="2" style="border:1px solid #000;">
		  <table>
		  <tr><td width="130px"><b>Invoice No</b></td><td>'.$arrData['billinvoiceno'].'</td></tr>
		  <tr><td><b>For</b></td><td>'.$arrData['invoiceperiod'].'</td></tr>
		  <tr><td><b>Date</b></td><td>'.$arrData['invoicedate'].'</td></tr>
		  <tr><td><b>Terms Of Payment</b></td><td>'.$arrData['billtypepayment'].'</td></tr>
		  </table>
		  </td>
		  </tr>
		  <tr>
		  <td width="40px" align="center" style="border:1px solid #000;">S No</td>
		  <td width="293px" align="center" style="border:1px solid #000;">DESCRIPTION</td>
		  <td width="50px" align="center" style="border:1px solid #000;">Qty</td>
		  <td width="125px" align="center" style="border:1px solid #000;">Unit Rent (P.M)</td>
		  <td width="130px" align="center" style="border:1px solid #000;">AMOUNT</td>
		  </tr>
		  '.$subTable.'
		  <tr>
		  <td style="border-right:1px solid #000;">&nbsp;</td>
		  <td style="border-right:1px solid #000;">&nbsp;</td>
		  <td colspan="2" align="center" style="border:1px solid #000;">TOTAL</td>
		  <td align="right" style="border:1px solid #000;">&#8377;&nbsp;'.number_format($strTotal,2).'</td>
		  </tr>
		  <tr>
		  <td colspan="5" style="border-top:1px solid #000;">
		  Make all checks payable to<br />
		  <b>CALTECH SOFT PVT LTD</b><br />
		  Account Number : 155405000816<br />
		  Bank : ICICI BANK<br />
		  Branch : ADAMBAKKAM<br />
		  IFSC Code : ICIC0001554
		  </td>
		  </tr>
		  </table>';
		  $returntext = $strMainTable;
		  
		  
			  $strInvName = 'INVOICE_'.$strInvNo.date('His');
			  $arrDataInv['client_id'] = 0;
			  $arrDataInv['invoice_id'] = 'CRS'.$arrData['billinvoiceno'];
			  $arrDataInv['invoice_period'] = $strInvDate;
			  $arrDataInv['generated_date'] = date('Y-m-d H:i:s');
			  $arrDataInv['invoice_file_name'] = 'INVOICE_CRS'.$arrData['billinvoiceno'];
			  $arrDataInv['payment_status'] = 'pending';
			  $arrDataInv['admin_id'] = $_SESSION['suserid'];
			  $arrDataInv['invoice_amount'] = $strTotal;
			  $arrDataInv['invoice_date'] = date("Y-m-d",strtotime($strInvDate));
			  $arrDataInv['invoice_html_disp'] = $strMainTable;
			  $arrDataInv['invoice_in_details'] = $arrData['billto'].":".$arrData['billtoaddress'].":".$arrData['billcontactno'];
			  $arrDataInv['invoice_vendor'] = $arrData['txtSysVendor'];

				$this->saveInvoice($arrDataInv);
			  
			  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			  $pdf->SetCreator(PDF_CREATOR);
			  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			  
			  if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			  require_once(dirname(__FILE__).'/lang/eng.php');
			  $pdf->setLanguageArray($l);
			  }
			  
			  $pdf->SetFont('dejavusans', '', 10);
			  $pdf->AddPage();
			  
			  $pdf->writeHTML($strMainTable, true, false, true, false, '');
			  $pdf->SetFillColor(255,255,0);
			  $pdf->lastPage();
			  //$pdf->Output($strInvName.'.pdf', 'I');
			  $pdf->Output(SERVER_ROOT.'/invoice/'.'INVOICE_CRS'.$arrData['billinvoiceno'].'.pdf', 'F');
			  //$returntext = $strInvName.'.pdf';	
	
		return $returntext;	
	}
	
	
	public function generateInvoiceDocument($arrData,$format="html")
	{
		  $returntext = "";
		  
		  $cid = $arrData['client_id'];		
		  $invoiceVendor = $arrData['txtSysVendor'];	
		 
		  $extraquery = "rental_status='yes'";
		  @$sDetails = $this->getClientSysDetails($cid,$extraquery);
		  $cDetails = $this->getClientDetailsById($cid); 		  
		 
		  $subTable = '';
		  $strTotal =0;
		  $arrCount = count($sDetails);
		  for($i=0; $i<$arrCount; $i++)
		  {
		  $strDec = $sDetails[$i]['system_type'].' - '.$sDetails[$i]['short_description'];
		  $strUnitRent = $sDetails[$i]['unit_rent'];
		  $strQty = $sDetails[$i]['system_qty'];
		  $strSubTot = ($strUnitRent * $strQty);
		  $strTotal = $strTotal + $strSubTot;
		  
		  $subTable .='<tr><td width="40px" align="center" style="border-right:1px solid #000;">'.($i + 1).'</td><td width="293px" align="center" style="border-right:1px solid #000;">'.$strDec.'</td><td width="50px" align="center" style="border-right:1px solid #000;">'.$strQty.'</td><td width="125px" align="right" style="border-right:1px solid #000;">&#8377;&nbsp;'.number_format($strUnitRent,2).'</td><td width="130px" align="right">&#8377;&nbsp;'.number_format($strSubTot,2).'</td></tr>';
		  }
		  
		  if($arrCount < 20)
		  {
		  $arrCountEmpty = 20 - $arrCount;
		  for($k=0; $k<$arrCountEmpty; $k++)
		  {
		  $subTable .='<tr><td width="40px" align="center" style="border-right:1px solid #000;">&nbsp;</td><td width="293px" align="center" style="border-right:1px solid #000;">&nbsp;</td><td width="50px" align="center" style="border-right:1px solid #000;">&nbsp;</td><td width="125px" align="right" style="border-right:1px solid #000;">&nbsp;</td><td width="130px" align="right">&nbsp;</td></tr>';
		  }
		  }
		  
		  $m = date('M');
		  $y = date('Y');
		  $d = $cDetails['invoice_date'];
		  
		  $strInvDate = $d.'-'.$m.'-'.$y;
		  $strInvNo = $cDetails['client_id'].date('m').$y;
		  
		  $strMainTable = '<table width="100%" style="border-collapse:collapse; border:1px solid #000;">
		  <tr>
		  <td colspan="5" style="border-bottom:1px solid #000;">
		  <table width="100%">
		  <tr>
		  <td align="center" rowspan="5" style="width:100px;"><img src="'.SITE_ROOT.'/templates/mblue/images/logo.jpg" alt="crs" width="100" height="100" border="0" /></td><td>&nbsp;</td></tr>
		  <tr><td align="right" style="color:#e00c21; width:"600px";">Caltech Soft Pvt Ltd</td></tr>
		  <tr><td align="right" style="width:"600px";"><span style="color:#58D3F7;">No:</span> 10/22, Thiruvalluvar 3<span style="vertical-align:super">rd</span> Street, Adambakkam, Chennai - 600088</td></tr>
		  <tr><td align="right"><span style="color:#58D3F7;">Phone No:</span> 044 22450151</td></tr>
		  <tr><td align="right"><span style="color:#58D3F7;">Email:</span> <a style="text-decoration:none;" href="mailto:info@caltechsoft.com">info@caltechsoft.com</a>, <span style="color:#58D3F7;">Website:</span> <a style="text-decoration:none;" href="www.caltechsoft.com" target="_blank">www.caltechsoft.com</a></td>
		  </tr></table>
		  </td></tr>
		  <tr>
		  <td colspan="3" style="border:1px solid #000;">
		  <table>
		  <tr><td width="100px"><b>Bill To</b></td><td><b>'.$cDetails['organisation'].'</b></td></tr>
		  <tr><td valign="top"><b>Address</b></td><td>'.$cDetails['address'].'</td></tr>
		  <tr><td><b>Contact No</b></td><td>'.$cDetails['cmobileno'].'</td></tr>
		  <tr><td><b>Email-Id</b></td><td>'.$cDetails['cemailid'].'</td></tr>
		  </table>
		  </td>
		  <td colspan="2" style="border:1px solid #000;">
		  <table>
		  <tr><td width="130px"><b>Invoice No</b></td><td>'.$strInvNo.'</td></tr>
		  <tr><td><b>For</b></td><td>Computers Rental</td></tr>
		  <tr><td><b>Date</b></td><td>'.$strInvDate.'</td></tr>
		  <tr><td><b>Terms Of Payment</b></td><td>Invoice</td></tr>
		  </table>
		  </td>
		  </tr>
		  <tr>
		  <td width="40px" align="center" style="border:1px solid #000;">S No</td>
		  <td width="293px" align="center" style="border:1px solid #000;">DESCRIPTION</td>
		  <td width="50px" align="center" style="border:1px solid #000;">Qty</td>
		  <td width="125px" align="center" style="border:1px solid #000;">Unit Rent (P.M)</td>
		  <td width="130px" align="center" style="border:1px solid #000;">AMOUNT</td>
		  </tr>
		  '.$subTable.'
		  <tr>
		  <td style="border-right:1px solid #000;">&nbsp;</td>
		  <td style="border-right:1px solid #000;">&nbsp;</td>
		  <td colspan="2" align="center" style="border:1px solid #000;">TOTAL</td>
		  <td align="right" style="border:1px solid #000;">&#8377;&nbsp;'.number_format($strTotal,2).'</td>
		  </tr>
		  <tr>
		  <td colspan="5" style="border-top:1px solid #000;">
		  Make all checks payable to<br />
		  <b>CALTECH SOFT PVT LTD</b><br />
		  Account Number : 155405000816<br />
		  Bank : ICICI BANK<br />
		  Branch : ADAMBAKKAM<br />
		  IFSC Code : ICIC0001554
		  </td>
		  </tr>
		  </table>';

		  
		  if($format == "pdf")
		  {
			  $strInvName = 'INVOICE_'.$strInvNo.date('His');
			  $arrDataInv['client_id'] = $cid;
			  $arrDataInv['invoice_id'] = $strInvNo;
			  $arrDataInv['invoice_period'] = $strInvDate;
			  $arrDataInv['generated_date'] = date('Y-m-d H:i:s');
			  $arrDataInv['invoice_file_name'] = $strInvName;
			  $arrDataInv['payment_status'] = 'pending';
			  $arrDataInv['admin_id'] = $_SESSION['suserid'];
			  $arrDataInv['invoice_amount'] = $strTotal;
			  $arrDataInv['invoice_date'] = date("Y-m-d",strtotime($strInvDate));
			  $arrDataInv['invoice_vendor'] = $invoiceVendor;
			  $this->saveInvoice($arrDataInv);
			  
			  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			  $pdf->SetCreator(PDF_CREATOR);
			  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			  
			  if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			  require_once(dirname(__FILE__).'/lang/eng.php');
			  $pdf->setLanguageArray($l);
			  }
			  
			  $pdf->SetFont('dejavusans', '', 10);
			  $pdf->AddPage();
			  
			  $pdf->writeHTML($strMainTable, true, false, true, false, '');
			  $pdf->SetFillColor(255,255,0);
			  $pdf->lastPage();
			  //$pdf->Output($strInvName.'.pdf', 'I');
			  $pdf->Output(SERVER_ROOT.'/invoice/'.$strInvName.'.pdf', 'F');
			  $returntext = $strInvName.'.pdf';
		  }
		  else
		  {
			  $returntext = $strMainTable;
		  }
		  
		  return $returntext;			
		
	}
	
	public function insertUpdateAccEntry($arrData)
	{		
		$db = new dbquery();	
		
		if($arrData['id'] != '0'){
			$db->update_table($arrData,TBL_PREFIX.'account_managment',$arrData['id']);
		}else{
			$db->insert_table($arrData,TBL_PREFIX.'account_managment');
		}
	}	
	
	public function insertUpdateChequeEntry($arrData)
	{		
		$db = new dbquery();	

		if($arrData['id'] != '0'){
			$db->update_table($arrData,TBL_PREFIX.'account_cheque_details',$arrData['id']);
		}else{
			$db->insert_table($arrData,TBL_PREFIX.'account_cheque_details');
		}
	}	
	
	public function insertUpdateServiceAccEntry($arrData)
	{		
		$db = new dbquery();	
		
		if($arrData['id'] != '0'){
			$db->update_table($arrData,TBL_PREFIX.'account_managment_service',$arrData['id']);
		}else{
			$db->insert_table($arrData,TBL_PREFIX.'account_managment_service');
		}
	}
	
	public function getAccEntryLists($extrasql = "")
	{	
		$extrasql = ($extrasql) ? " where ".$extrasql : "";
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."account_managment ".$extrasql." order by expense_date ASC");
		
		while ($row = mysql_fetch_assoc($query)) {
			$entryLists[] =  $row;
		}
		return $entryLists;
	}
	
	public function getChkEntryLists($extrasql = "")
	{	
		$extrasql = ($extrasql) ? " where ".$extrasql : "";
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."account_cheque_details ".$extrasql." order by cheque_date ASC");
		
		while ($row = mysql_fetch_assoc($query)) {
			$entryLists[] =  $row;
		}
		return $entryLists;
	}
	
	public function getServiceAccEntryLists($extrasql = "")
	{	
		$extrasql = ($extrasql) ? " where ".$extrasql : "";
		$db = new dbquery();		
		$query = mysql_query("SELECT * from ".TBL_PREFIX."account_managment_service ".$extrasql." order by expense_date ASC");
		
		while ($row = mysql_fetch_assoc($query)) {
			$entryLists[] =  $row;
		}
		return $entryLists;
	}
	
	public function getRecordByCustomQueryNew($tblName,$field="*",$extraSql)
	{		
		$extraSql = ($extraSql) ? " where ".$extraSql: "";	
		$query = mysql_query("SELECT ".$field." from ".TBL_PREFIX.$tblName.$extraSql);		
		$recordset = @mysql_fetch_array($query);
		return @$recordset;
	}
	
	public function closeAccountSummary($arrData)
	{		
		$db = new dbquery();	
		
		$extraSql = "rec_active_status = 1 and cash_type = 'credit'";
		$totalPaymentDetails = $this->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
		$totalIncome = ($totalPaymentDetails["totamount"]) ? $totalPaymentDetails["totamount"] : "0";
		
		
		$extraSql = "rec_active_status = 1 and cash_type = 'debit'";
		$totalPaymentDetails = $this->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
		$totalExpense = ($totalPaymentDetails["totamount"]) ? $totalPaymentDetails["totamount"] : "0";
		
		$totAvailableBal = $totalIncome-$totalExpense;
		
		//update previous entry
		$query = mysql_query("update ".TBL_PREFIX."account_managment set closing_date='".date('Y-m-d H:i:s')."',rec_active_status=0 where rec_active_status = 1");
		//insert carry forward data
		$arrNewData['description'] = "Account Closing on ".date('Y-m-d H:i:s');
		$arrNewData['cash_type'] = "credit";
		$arrNewData['payment_type'] = "cash";
		$arrNewData['expense_date'] = date('Y-m-d');
		$arrNewData['payment_remarks'] = "Account Closing on ".date('Y-m-d H:i:s');
		$arrNewData['rec_active_status'] = 1;
		$arrNewData['expense_type'] = "general";
		$arrNewData['entry_amount'] = $totAvailableBal;
		$this->insertUpdateAccEntry($arrNewData);		
		
	}
	
	public function updateInvoiceTrashStatus($recID)
	{
		$query = mysql_query("update ".TBL_PREFIX."invoice_list set archive_status='1' where id = ".$recID);
	}
	
	public function updateServiceTrashStatus($recID)
	{
		$query = mysql_query("update ".TBL_PREFIX."new_service set archive_status='1' where id = ".$recID);
	}
	
	public function updateLeadTrashStatus($recID)
	{
		$query = mysql_query("update ".TBL_PREFIX."new_leads set archive_status='1' where id = ".$recID);
	}
	
	
	public function updateClientTrashStatus($recID)
	{
		$query = mysql_query("update ".TBL_PREFIX."client set active='no' where id = ".$recID);
		$query = mysql_query("update ".TBL_PREFIX."system_details set rental_status='no' where client_id = ".$recID);
	}
	
	public function updateSystemTrashStatus($recID)
	{
		//$query = mysql_query("update ".TBL_PREFIX."client set active='no' where id = ".$recID);
		$query = mysql_query("update ".TBL_PREFIX."system_details set trash_status='1',rental_status='no' where id = ".$recID);
	}
	
	
}

?>