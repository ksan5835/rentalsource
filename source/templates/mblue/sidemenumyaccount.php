<?php
	/*$totDesk = $objPage->getCountRecords("system_details","id",$cntsql);	
	$totLap = $objPage->getCountRecords("system_details","id",$cntsql);
	
	$cntsql = " trash_status='0' and show_status='show'";
	$vacancyCount = $objPage->getCountRecords("units","id",$cntsql);*/
	
	$cntsql = "archive_status = 0";
	$totInvoice = $objPage->getCountRecords("invoice_list","id",$cntsql);
	
	$cntsql = "archive_status = 0 and payment_status = 'pending'";
	$pendingInvoiceCount = $objPage->getCountRecords("invoice_list","id",$cntsql);	
	
	$cntsql = "archive_status = 0 and payment_status = 'paid'";
	$paidInvoiceCount = $objPage->getCountRecords("invoice_list","id",$cntsql);
	
	$cntsql = "archive_status = 0 and payment_status = 'partial'";
	$partialPaidInvoiceCount = $objPage->getCountRecords("invoice_list","id",$cntsql);
	
	$extraSql = "archive_status = 0";
	$totalPaymentDetails = $objPage->getRecordByCustomQuery("invoice_list",$field="sum(invoice_amount) as totamount",$extraSql);
	
	$totalAmount = ($totalPaymentDetails) ? $totalPaymentDetails["totamount"] : 0;
	
	unset($totalPaymentDetails);
	$extraSql = "archive_status = 0 and payment_status = 'paid'";
	$totalPaymentDetails = $objPage->getRecordByCustomQuery("invoice_list",$field="sum(invoice_amount) as totamount",$extraSql);	
	$totalCollectedAmount = ($totalPaymentDetails["totamount"]) ? $totalPaymentDetails["totamount"] : "0";
	
	$extraSql = "archive_status = 0 and payment_status = 'partial'";
	$partialTotalPaymentDetails = $objPage->getRecordByCustomQuery("invoice_list",$field="sum(partial_amount) as totpartamount",$extraSql); 	
	$partialTotalCollectedAmount = ($partialTotalPaymentDetails["totpartamount"]) ? $partialTotalPaymentDetails["totpartamount"] : "0";
	
	unset($totalPaymentDetails);
	$extraSql = "archive_status = 0 and payment_status = 'pending'";
	$totalPaymentDetails = $objPage->getRecordByCustomQuery("invoice_list",$field="sum(invoice_amount) as totamount",$extraSql);
	
	$totalpendingAmount = ($totalPaymentDetails["totamount"]) ? $totalPaymentDetails["totamount"] : "0";
	
		
	unset($totalSystemDetailsNew);
	$extraSql = "rental_status = 'yes' and trash_status='0'";
	$totalSystemDetailsNew = $objPage->getRecordByCustomQuery("system_details",$field="sum(total_amount) as totCount",$extraSql);
	$totalRentalAmountTotal = ($totalSystemDetailsNew["totCount"]) ? $totalSystemDetailsNew["totCount"] : "0";
	
	
	
	
?>



<div class="leftblock">
<h3>Invoice Details</h3>
<table cellspacing="5">
<tr><td><strong>Total Invoice</strong></td><td>:</td><td><?php echo $totInvoice;?></td></tr>
<tr><td class="highlight"><strong>Pending</strong></td><td>:</td><td><?php echo $pendingInvoiceCount;?></td></tr>
<tr><td><strong>Partial</strong></td><td>:</td><td><?php echo $partialPaidInvoiceCount;?></td></tr>
<tr><td><strong>Processed</strong></td><td>:</td><td><?php echo $paidInvoiceCount;?></td></tr>
<tr><td><strong>Total Amount</strong></td><td>:</td><td>Rs.<?php echo $totalAmount;?></td></tr>
<tr><td><strong>Collected So far</strong></td><td>:</td><td>Rs.<?php echo $totalCollectedAmount+$partialTotalCollectedAmount;?></td></tr>
<tr><td class="highlight"><strong>Yet to Collect</strong></td><td>:</td><td>Rs.<?php echo $totalpendingAmount;?></td></tr>
</table>
</div>

<div class="leftblock">
<h3>Monthly Rental Income</h3>
<table cellspacing="7" cellspacing="7" border="0">
<tr><th>&nbsp;</th><th>&nbsp;</th><th>Total Amount</th></tr>

<?php $arrsystemVendor = array("caltech","caltechravi","bhuvan","bhuvansankar","bhuvanarun","bhuvanvenkat","bhuvanmaha"); ?>

<?php for($i=0;$i<count($arrsystemVendor);$i++){ ?>

<?php 

	unset($totalSystemDetailsNew);
	$extraSql = "rental_status = 'yes' and rental_vendor='".$arrsystemVendor[$i]."' and trash_status='0'";
	$totalSystemDetailsNew = $objPage->getRecordByCustomQuery("system_details",$field="sum(total_amount) as totCount",$extraSql);
	$totalRentalAmount = ($totalSystemDetailsNew["totCount"]) ? $totalSystemDetailsNew["totCount"] : "0";


?>


<tr><td><strong><?php echo $arrsystemVendor[$i];?></strong></td><td><?php echo $desktopcount;?></td><td><?php echo "RS.".$totalRentalAmount; ?></td></tr>
<?php } ?>

<tr><td><h2>Net Income</h2></td><td>: </td><td><?php echo "<h2>RS.".($totalRentalAmountTotal)."</h2>"; ?></td></tr>
</table>
</div>
<div class="leftblock">
<h3>Service Call Accounts</h3>
<a href='index.php?option=com_pos&view=serviceaccounts' ><input type="submit"  value="Service Accounts" style='cursor:pointer;' /></a>
</div>
<?php if(@$_REQUEST['view'] == 'invoice'){
	$vID = @$_REQUEST['vid'];
	if($vID != ''){
		$extraSql = "invoice_id ='".$vID."'";
	}else{
		$extraSql = "invoice_id ='".@$_REQUEST['rid']."'";
	}
		$listComments = $objPage->getPaymentComments($extraSql);
		
		if(count($listComments) > 0){
			echo '<div class="leftblock" align="left"><h3>Payment Status Comments</h3>';
			foreach($listComments as $listComment){
				echo "<b>Status : </b>".ucfirst($listComment['pay_status'])."<br />";	
				echo "<b>Comments: </b>".$listComment['pay_comments']."<br />";	
				echo "<b>Date: </b>".$listComment['date']."<hr />";	
			}
			echo '</div>';
		}
	
	
echo '<div class="leftblock" align="right">
<a class="edit" datgid="'.$clientSysDet[$i]['id'].'"><input type="button" value="Payment status" class="paymentstatus" /></a>
</div>';
}
?>