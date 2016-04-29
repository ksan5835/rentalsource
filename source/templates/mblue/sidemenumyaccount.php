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
	
	$cntsql = "rental_status = 'yes' and system_type = 'desktop' and trash_status='0'";
	$desktopcount = $objPage->getCountRecords("system_details","sum(id",$cntsql);
	
	unset($totalSystemDetails);
	$extraSql = "rental_status = 'yes' and system_type = 'desktop' and trash_status='0'";
	$totalSystemDetails = $objPage->getRecordByCustomQuery("system_details",$field="sum(system_qty) as totCount",$extraSql);
	$desktopcount = ($totalSystemDetails["totCount"]) ? $totalSystemDetails["totCount"] : "0";
	
	unset($totalSystemDetails);
	$extraSql = "rental_status = 'yes' and system_type = 'laptop' and trash_status='0'";
	$totalSystemDetails = $objPage->getRecordByCustomQuery("system_details",$field="sum(system_qty) as totCount",$extraSql);
	$laptopCount = ($totalSystemDetails["totCount"]) ? $totalSystemDetails["totCount"] : "0";
	
	unset($totalSystemDetails);
	$extraSql = "rental_status = 'yes' and system_type = 'printer' and trash_status='0'";
	$totalSystemDetails = $objPage->getRecordByCustomQuery("system_details",$field="sum(system_qty) as totCount",$extraSql);
	$printerCount = ($totalSystemDetails["totCount"]) ? $totalSystemDetails["totCount"] : "0";
	
	unset($totalSystemDetails);
	$extraSql = "rental_status = 'yes' and system_type = 'ups' and trash_status='0'";
	$totalSystemDetails = $objPage->getRecordByCustomQuery("system_details",$field="sum(system_qty) as totCount",$extraSql);
	$upsCount = ($totalSystemDetails["totCount"]) ? $totalSystemDetails["totCount"] : "0";
	
	unset($totalSystemDetails);
	$extraSql = "rental_status = 'yes' and system_type = 'monitor' and trash_status='0'";
	$totalSystemDetails = $objPage->getRecordByCustomQuery("system_details",$field="sum(system_qty) as totCount",$extraSql);
	$monitorCount = ($totalSystemDetails["totCount"]) ? $totalSystemDetails["totCount"] : "0";
	
	unset($totalSystemDetailsNew);
	$extraSql = "rental_status = 'yes' and system_type = 'desktop' and trash_status='0'";
	$totalSystemDetailsNew = $objPage->getRecordByCustomQuery("system_details",$field="sum(total_amount) as totCount",$extraSql);
	$desktopcountPrice = ($totalSystemDetailsNew["totCount"]) ? $totalSystemDetailsNew["totCount"] : "0";
	
	unset($totalSystemDetailsNew);
	$extraSql = "rental_status = 'yes' and system_type = 'laptop' and trash_status='0'";
	$totalSystemDetailsNew = $objPage->getRecordByCustomQuery("system_details",$field="sum(total_amount) as totCount",$extraSql);
	$laptopCountPrice = (totalSystemDetailsNew) ? $totalSystemDetailsNew["totCount"] : "0";
	
	unset($totalSystemDetailsNew);
	$extraSql = "rental_status = 'yes' and system_type = 'printer' and trash_status='0'";
	$totalSystemDetailsNew = $objPage->getRecordByCustomQuery("system_details",$field="sum(total_amount) as totCount",$extraSql);
	$printerCountPrice = ($totalSystemDetailsNew["totCount"]) ? $totalSystemDetailsNew["totCount"] : "0";
	
	unset($totalSystemDetailsNew);
	$extraSql = "rental_status = 'yes' and system_type = 'ups' and trash_status='0'";
	$totalSystemDetailsNew = $objPage->getRecordByCustomQuery("system_details",$field="sum(total_amount) as totCount",$extraSql);
	$upsCountPrice = (totalSystemDetailsNew) ? $totalSystemDetailsNew["totCount"] : "0";
	
	unset($totalSystemDetailsNew);
	$extraSql = "rental_status = 'yes' and system_type = 'monitor' and trash_status='0'";
	$totalSystemDetailsNew = $objPage->getRecordByCustomQuery("system_details",$field="sum(total_amount) as totCount",$extraSql);
	$monitorCountPrice = (totalSystemDetailsNew) ? $totalSystemDetailsNew["totCount"] : "0";
	
	
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
<tr><td><strong>Total Desktop</strong></td><td><?php echo $desktopcount;?></td><td><?php echo "RS.".$desktopcountPrice; ?></td></tr>
<tr><td ><strong>Total Laptop</strong></td><td><?php echo $laptopCount;?></td><td><?php echo "RS.".$laptopCountPrice; ?></td></tr>
<tr><td><strong>Total Printer</strong></td><td><?php echo $printerCount;?></td><td><?php echo "RS.".$printerCountPrice; ?></td></tr>
<tr><td><strong>Total UPS</strong></td><td><?php echo $upsCount;?></td><td><?php echo "RS.".$upsCountPrice; ?></td></tr>
<tr><td><strong>Total Monitor</strong></td><td><?php echo $monitorCount;?></td><td><?php echo "RS.".$monitorCountPrice; ?></td></tr>
<tr><td><h2>Net Income</h2></td><td>: </td><td><?php echo "<h2>RS.".($desktopcountPrice + $laptopCountPrice + $printerCountPrice + $upsCountPrice + $monitorCountPrice)."</h2>"; ?></td></tr>
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