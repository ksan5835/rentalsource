<?php
include_once(SERVER_ROOT . '/templates/mblue/header.html');
include_once(SERVER_ROOT . '/lib/userdata.php');
?>
<script language="javascript">
	jQuery(document).ready(function(){
	jQuery("#frmAddClient").validationEngine({binded: false});	
	});
</script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#example').dataTable({
            "sPaginationType": "full_numbers", "aoColumnDefs": [{ "bSortable": false, "aTargets": [0
                    ]
            }]
        });
    });
 </script>
 <script>$(function() { $( "#dDate" ).datepicker({dateFormat: "dd-mm-yy"}); }); </script>
 <script>$(function() { $( "#rDate" ).datepicker({dateFormat: "dd-mm-yy"}); }); </script>
<div class="innerhome">
<table width="100%">
<tr><td valign="top">
<h3>Clients</h3>
<div class="ctlmenu">
<p>Manage Clients add new , edit , delete Clients</p>
</div>
<div style="clear:both;"></div>
<?php
@$cID = $_REQUEST['cid'];
@$eStatus = $_REQUEST['edit'];
if($cID)
{
	$cDetails = $objPage->getClientDetailsById($cID);
	$dDate = ($cDetails['start_date']) ? date("d-m-Y",strtotime($cDetails['start_date'])) : date("d-m-Y");
	$rDate = ($cDetails['end_date']) ? date("d-m-Y",strtotime($cDetails['end_date'])) : date("d-m-Y");
	$DurationType = $cDetails['duration_type'];
	$strDurVal = $cDetails['duration'];
	$strClientId = $cDetails['client_id'];
	$strInvoiceVal = $cDetails['invoice_date'];
}
if(!$cID)
{
	$cID = 0;
	$strClientId = $objPage->generateClientId();
}

$arrDurationType = array('month','year');
$strDurType ='<option value="">-Select-</option>';
for($dur =0; $dur < count($arrDurationType); $dur++)
{
	$selStatus = ($arrDurationType[$dur] == @$DurationType) ? 'selected="selected"' : '';
	$strDurType .= '<option value="'.$arrDurationType[$dur].'" '.$selStatus.'>'.ucfirst($arrDurationType[$dur]).'</option>';
}

$strDur = '<option value="">-Select-</option>';
for($t = 1; $t <= 12; $t++)
{
	$sel = ($t == @$strDurVal) ? 'selected="selected"' : '';
	$strDur .='<option value="'.$t.'" '.$sel.'>'.$t.'</option>';
}

$strInvoice ='<option value="">-Select-</option>';
for($invoice = 1; $invoice <= 31; $invoice++)
{
	$sels = ($invoice == @$strInvoiceVal) ? 'selected="selected"' : '';
	$strInvoice .='<option value="'.$invoice.'" '.$sels.'>'.$invoice.'</option>';
}

?>
<form method="post" id="frmAddClient" name="frmAddClient" action="index.php?option=com_pos&task=addClient">
<table width="100%" border="0">
<tr><td colspan="2"><h3>Client Details</h3><div style="border:1px dashed #b1b1b1;"></div></td></tr>
<tr><td>Client Id</td><td><input type="text" name="txtClientId" class="textinputcommon" readonly="readonly" value="<?php echo @$strClientId; ?>" /></td></tr>
<tr><td>Client Name</td><td><input type="text" name="txtClientName" class="validate[required] textinputcommon" value="<?php echo @$cDetails['client_name']; ?>" /></td></tr>
<tr><td>Organisation</td><td><input type="text" name="txtOrg" class="validate[required] textinputcommon" value="<?php echo @$cDetails['organisation']; ?>" /></td></tr>
<tr><td valign="top">Address</td><td><textarea name="txtAddress" class="validate[required] textinputAreacommon"><?php echo @$cDetails['address']; ?></textarea></td></tr>
<tr><td>Email</td><td><input type="text" name="txtEmail" class="validate[required,custom[email]] textinputcommon" value="<?php echo @$cDetails['emailid']; ?>" /></td></tr>
<tr><td>Mobile</td><td><input type="text" name="txtMobile" class="validate[required,custom[number]] textinputcommon" value="<?php echo @$cDetails['mobileno']; ?>" /></td></tr>
<tr><td>LandLine</td><td><input type="text" name="txtLandLine" class="validate[required,custom[number]] textinputcommon" value="<?php echo @$cDetails['landline']; ?>" /></td></tr>
<tr><td colspan="2"><h3>Contact Person</h3><div style="border:1px dashed #b1b1b1;"></div></td></tr>
<tr><td>Name</td><td><input type="text" name="txtContactPerson" class="validate[required] textinputcommon" value="<?php echo @$cDetails['contact_person']; ?>" /></td></tr>
<tr><td>Email</td><td><input type="text" name="txtcEmail" class="validate[required,custom[email]] textinputcommon" value="<?php echo @$cDetails['cemailid']; ?>" /></td></tr>
<tr><td>Mobile</td><td><input type="text" name="txtcMobile" class="validate[required,custom[number]] textinputcommon" value="<?php echo @$cDetails['cmobileno']; ?>" /></td></tr>
<tr><td colspan="2"><h3>Deposit and Cheque details</h3><div style="border:1px dashed #b1b1b1;"></div></td></tr>
<tr><td>Deposit Months</td><td><input type="text" name="txtDepositmonths" class="textinputcommon" value="<?php echo @$cDetails['deposit_months']; ?>" /></td></tr>
<tr><td>Deposit Amount</td><td><input type="text" name="txtDepositAmount" class="textinputcommon" value="<?php echo @$cDetails['deposit_amount']; ?>" /></td></tr>
<tr><td>No.of Cheque Leaf</td><td><input type="text" name="txtnCheque" class="textinputcommon" value="<?php echo @$cDetails['num_cheque']; ?>" /></td></tr>
<tr><td>Total Cheque Amount</td><td><input type="text" name="txtcAmount" class="textinputcommon" value="<?php echo @$cDetails['total_cheque_amount']; ?>" /></td></tr>
<tr><td colspan="2"><h3>System Details</h3><div style="border:1px dashed #b1b1b1;"></div></td></tr>
<tr><td>Total No. of Systems</td><td><input type="text" name="txtTotSys" class="validate[required,custom[number]] textinputcommon" value="<?php echo @$cDetails['total_systems']; ?>" /></td></tr>
<tr><td>Duration Type</td><td><select name="selDurationType" class="validate[required] textinputcommon"><?php echo $strDurType; ?></td></tr>
<tr><td>Duration</td><td><select name="selDuration" class="validate[required] textinputcommon"><?php echo $strDur; ?></td></tr>
<tr><td>Start Date</td><td><input type="text" id="dDate" name="txtDeliveryDate" class="validate[required] textinputcommon" value="<?php echo @$dDate; ?>" /></td></tr>
<tr><td>End Date</td><td><input type="text" id="rDate" name="txtReturnDate" class="validate[required] textinputcommon" value="<?php echo @$rDate; ?>" /></td></tr>
<tr><td>Invoice Date</td><td><select name="selInvoiceDate" class="validate[required] textinputcommon"><?php echo $strInvoice; ?></select></td></tr>
<tr><td colspan="2"><h3>Document</h3><div style="border:1px dashed #b1b1b1;"></div></td></tr>
<tr><td colspan="2">
<table width="80%" class="gridtable">
<th>Document Type</th><th>View</th><th>Verified By</th><th><?php if($eStatus == 1){ ?><a class="udoc" href="#">Add</a></th><?php } ?>
<?php
@$docDet = $objPage->getDocumentDet($cID);
if($docDet)
{
	for($i = 0; $i < count($docDet); $i++)
	{
		$strDocUrl = SITE_ROOT.'/documents/'.$docDet[$i]['document_name'];
		$strVerify = ($docDet[$i]['verifiedby']) ? $docDet[$i]['verifiedby'] : '--';
		echo '<tr>';
		echo '<td>'.$docDet[$i]['document_type'].'</td><td><a href="'.$strDocUrl.'" target="_blank">View</a></td><td>'.$strVerify.'</td>';
		echo ($eStatus == 1) ? '<td><a datgid="'.$docDet[$i]['id'].'" class="edit" href="#">Edit</a></td>' : '<td>--</td>';
		echo '</tr>';
	}
}
?>
</table>
</td></tr>
<tr><td colspan="2"><h3>Additional Details</h3><div style="border:1px dashed #b1b1b1;"></div></td></tr>
<tr><td>Comments</td><td><textarea name="txtComments" class="validate[required] textinputAreacommon"><?php echo @$cDetails['comments']; ?></textarea></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" class="btnsubmit" value="Save" /></td></tr>
</table>
<input type="hidden" id="recid" name="recid" value="<?php echo @$cID; ?>" />
</form>

</td>
<td width="30%" valign="top"> 

<?php include_once(SERVER_ROOT . '/templates/mblue/sidemenumyaccount.php'); ?>

 </td>
</tr>
</table>

</div>

<script language="javascript">
	
	jQuery('.udoc').click(function(){		
		jQuery('#uploaddoc').modal({minHeight:100,minWidth:450});			
	});
	
	jQuery('.rstpwd').click(function(){		
		jQuery('#updatedeadline').modal({minHeight:300,minWidth:450});			
	});	
	
	jQuery('.edit').click(function(){		
		var rId = jQuery(this).attr("datgid");	
		jQuery('#updatedeadline').modal({minHeight:100,minWidth:450});	
		jQuery('#recId').val(rId);		
	});
	
</script>
<div id="uploaddoc" style="display:none;">
<form method="post" id="frmUploadDoc" name="frmUploadDoc" action="index.php?option=com_pos&task=uploaddoc" enctype="multipart/form-data">
<span class="stitle"><h3>Upload Document</h3></span>
<table>
<tr><td>Document Type</td><td><input type="text" name="txtdocType" class="textinputcommon" /></td></tr>
<tr><td colspan="2"><input type="file" name="fileDoc" /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="btnsubmit" value="Save" /></td></tr>
</table>
<input type="hidden" name="cID" value="<?php echo @$cID; ?>" />
</form>
</div>

<div id="updatedeadline" style="display:none;">
<form method="post" id="extenddeadline" name="extenddeadline" action="index.php?option=com_pos&task=updateDocStatus">
<span class="stitle"><h3>Update Status</h3></span>
<table>
<tr><td>Verified By</td><td><input type="text" name="txtVerified" class="textinputcommon" /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="btnsubmit" value="Save" /></td></tr>
</table>
<input type="hidden" name="cID" value="<?php echo @$cID; ?>" />
<input type="hidden" id="recId" name="recId" value="0" />
</form>
</div>
<?php include_once(SERVER_ROOT . '/templates/mblue/footer.html'); ?>