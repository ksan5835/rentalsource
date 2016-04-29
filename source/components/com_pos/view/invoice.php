<?php
include_once(SERVER_ROOT . '/templates/mblue/header.html');
include_once(SERVER_ROOT . '/lib/userdata.php');

?>
<div class="innerhome">
<table width="100%">
<tr><td valign="top">
<h3>Generate Invoice</h3>

<?php
if($_POST['btn_newinvoice'])
{
	
	//$extraSql = "client_id ='0'";
		//$getPath = $objPage->getRecordByCustomQuery("invoice_list","invoice_file_name",$extraSql);

		
			echo '<a href="'.SITE_ROOT .'/invoice/'.$getPath['invoice_file_name'].'.pdf" target="_blank"><input type="button" value="Download Invoice" class="rstpwd" /></a>';
	
?>	
	<!-- $arrData =$_POST;
	//$_SESSION['susername']  = $arrData;
	//echo $objPage->generateNewInvoiceDocument($arrData,"html"); -->
	
	
	
	<form name="frmInvoice" method="post" action="index.php?option=com_pos&task=generateInvnew">
<div align="right" style="float:right;">
</div>

<br /><br /><br />
<div style="margin-left:5px;">
<?php
$arrData = $_POST;
echo $objPage->generateNewInvoiceDocument($arrData,'pdf');

?>
</div>
<input type="hidden" name="client_id" id="client_id" value="<?php echo $cId; ?>" />
</form>
<?php	
}
else
{
	$cId = $_REQUEST['cid'];
	$rId = $_REQUEST['rid'];
	$vId = $_REQUEST['vid'];
	
		$cDetails = $objPage->getClientDetailsById($cId); 
?>
<br />
<div class="ctlmenu">
<table>
<tr><td><strong>Client Name</strong></td><td><?php echo ucfirst($cDetails['client_name']).' - '.ucfirst($cDetails['organisation']); ?></td></tr>
<?php 
@$rentalCategory = $objPage->getRentalCategory();
$totCat = count($rentalCategory);	
for($i=0;$i<$totCat;$i++){
$sysCategory = $rentalCategory[$i]['category_meta'];

$extraSql = "client_id ='".$cId."' and system_type='".$sysCategory."'";
$countRec = $objPage->getRecordByCustomQuery("system_details","sum(system_qty) as totQty",$extraSql);
if($countRec['totQty']){	
?>
<tr><td><strong>Total <?php echo $rentalCategory[$i]['rental_category'];?></strong></td><td><?php echo $countRec['totQty'];?></td></tr>

<?php } } ?>
</tr>
</table>
</div>

<form name="frmInvoice" method="post" action="index.php?option=com_pos&task=generateInv">
<div align="right" style="float:right;">
<?php 
		if(isset($cId)){
			$extraSql = "client_id ='".$cId."' and archive_status='0'";
		}else{
			$extraSql = "id ='".$rId."' and archive_status='0'";			
		}
		$getPath = $objPage->getRecordByCustomQuery("invoice_list","invoice_file_name",$extraSql);
/*<a href="#"><input type="button" value="Send Mail" class="sendmail" /></a>&nbsp;&nbsp;*/
		if($getPath['invoice_file_name'] != '' ){ 
			echo '<a href="'.SITE_ROOT .'/invoice/'.$getPath['invoice_file_name'].'.pdf" target="_blank"><input type="button" value="Download Invoice" class="rstpwd" /></a>';
		}else{
			echo '<input type="submit" value="Generate" class="rstpwd" />';
			
		}
?>
</div>
<br /><br /><br />
<div style="margin-left:5px;">
<?php

$arrData['client_id'] = $cId;
if(isset($cId)){
echo $objPage->generateInvoiceDocument($arrData);
}else{
	$getInvoice = $objPage->getRecordByCustomQuery("invoice_list","invoice_html_disp",$extraSql);
	echo $getInvoice['invoice_html_disp'];
}

?>
</div>
<input type="hidden" name="client_id" id="client_id" value="<?php echo $cId; ?>" />
</form>

<?php } ?>

</td>
<td width="30%" valign="top"> 

<?php include_once(SERVER_ROOT . '/templates/mblue/sidemenumyaccount.php'); ?>

 </td>
</tr>
</table>

</div>
<script language="javascript">
	
	jQuery('.paymentstatus').click(function(){		
		jQuery('#updatedeadline').modal({minHeight:230,minWidth:350});			
	});	
	
	jQuery('.sendmail').click(function(){		
	var r = confirm("Are you sure to send the invoice mail ?");
	
	var userid = $('#client_id').val();

	if(r == true){
			jQuery.post("index.php?option=com_pos&task=sendinvoicemail", { cid: userid  })
		}else{
			return false;
		}
	});	
	
	jQuery('.edit').click(function(){		
		
		var uId = jQuery(this).attr("datgid");	
		
		jQuery('#updatedeadline').modal({minHeight:270,minWidth:350});	
		getUserForm(uId);
				
	});
	
	function getUserForm(userid)
	{
		jQuery.post("index.php?option=com_pos&task=paymentstatus", { cid: userid  },
		function(data) {
			jQuery(".ldform").html(data);											
		});
	}
	
</script>
<div id="updatedeadline" style="display:none;">
<form method="post" id="extenddeadline" name="extenddeadline" action="index.php?option=com_pos&task=updatePaymentStatus">
<span class="stitle"><h3>Payment Details</h3></span>
<div class="ldform"></div>
<input type="hidden" name="cId" value="<?php echo $cId; ?>" />
<input type="hidden" name="rId" value="<?php echo $rId; ?>" />
<input type="hidden" name="vId" value="<?php echo $vId; ?>" />
</form>
<script language="javascript">
	getPaymentForm(0);
</script>


<?php include_once(SERVER_ROOT . '/templates/mblue/footer.html'); ?>