<?php
	
	unset($totalPaymentDetails);
	$extraSql = "rec_active_status = 1 and cash_type = 'credit'";
	$totalPaymentDetails = $objPage->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
	$totalIncome = ($totalPaymentDetails["totamount"]) ? $totalPaymentDetails["totamount"] : "0";
	
	$extraSql = "rec_active_status = 1 and cash_type = 'credit' and payment_type='cash'";
	$totalPaymentDetails = $objPage->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
	$totIncomebyCash = ($totalPaymentDetails["totamount"]) ? $totalPaymentDetails["totamount"] : "0";
	
	$extraSql = "rec_active_status = 1 and cash_type = 'credit' and payment_type='cheque'";
	$totalPaymentDetails = $objPage->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
	$totincomebycheque = ($totalPaymentDetails["totamount"]) ? $totalPaymentDetails["totamount"] : "0";
	
	$extraSql = "rec_active_status = 1 and cash_type = 'debit'";
	$totalPaymentDetails = $objPage->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
	$totalExpense = ($totalPaymentDetails["totamount"]) ? $totalPaymentDetails["totamount"] : "0";
	
	$totAvailableBal = $totalIncome-$totalExpense;
	
	//Prev Month
	
	/*unset($totalPaymentDetailsNew);
	$extraSql = "rec_active_status = 0 and cash_type = 'credit' and expense_date BETWEEN '2015-12-01' AND '2015-12-31'";
	$totalPaymentDetailsNew = $objPage->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
	$totalIncomeNew = ($totalPaymentDetailsNew["totamount"]) ? $totalPaymentDetailsNew["totamount"] : "0";
	
	$extraSql = "rec_active_status = 0 and cash_type = 'credit' and payment_type='cash' and expense_date BETWEEN '2015-12-01' AND '2015-12-31'";
	$totalPaymentDetailsNew = $objPage->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
	$totIncomebyCashNew = ($totalPaymentDetailsNew["totamount"]) ? $totalPaymentDetailsNew["totamount"] : "0";
	
	$extraSql = "rec_active_status = 0 and cash_type = 'credit' and payment_type='cheque' and expense_date BETWEEN '2015-12-01' AND '2015-12-31'";
	$totalPaymentDetailsNew = $objPage->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
	$totincomebychequeNew = ($totalPaymentDetailsNew["totamount"]) ? $totalPaymentDetailsNew["totamount"] : "0";
	
	$extraSql = "rec_active_status = 0 and cash_type = 'debit'  and expense_date BETWEEN '2015-12-01' AND '2015-12-31'";
	$totalPaymentDetailsNew = $objPage->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
	$totalExpenseNew = ($totalPaymentDetailsNew["totamount"]) ? $totalPaymentDetailsNew["totamount"] : "0";
	
	$totAvailableBalNew = $totalIncomeNew-$totalExpenseNew;*/
	
	unset($totalPaymentDetailsNew);
	$extraSql = "rec_active_status = 0 and cash_type = 'credit' and MONTH( expense_date ) = (MONTH(NOW()) - 1)";
	$totalPaymentDetailsNew = $objPage->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
	$totalIncomeNew = ($totalPaymentDetailsNew["totamount"]) ? $totalPaymentDetailsNew["totamount"] : "0";
	
	$extraSql = "rec_active_status = 0 and cash_type = 'credit' and payment_type='cash' and MONTH( expense_date ) = (MONTH(NOW()) - 1)";
	$totalPaymentDetailsNew = $objPage->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
	$totIncomebyCashNew = ($totalPaymentDetailsNew["totamount"]) ? $totalPaymentDetailsNew["totamount"] : "0";
	
	$extraSql = "rec_active_status = 0 and cash_type = 'credit' and payment_type='cheque' and MONTH( expense_date ) = (MONTH(NOW()) - 1)";
	$totalPaymentDetailsNew = $objPage->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
	$totincomebychequeNew = ($totalPaymentDetailsNew["totamount"]) ? $totalPaymentDetailsNew["totamount"] : "0";
	
	$extraSql = "rec_active_status = 0 and cash_type = 'debit'  and MONTH( expense_date ) = (MONTH(NOW()) - 1)";
	$totalPaymentDetailsNew = $objPage->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
	$totalExpenseNew = ($totalPaymentDetailsNew["totamount"]) ? $totalPaymentDetailsNew["totamount"] : "0";
	
	$totAvailableBalNew = $totalIncomeNew-$totalExpenseNew;
	
?>



<div class="leftblock">
<h3>Account Details</h3>
<table cellspacing="5">
<?php $arrsystemVendor = array("common","caltech","caltechravi","bhuvan","bhuvansankar","bhuvanarun","bhuvanvenkat","bhuvanmaha"); ?>

<?php for($i=0;$i<count($arrsystemVendor);$i++){ ?>
<?php 

	$extraSql = "rec_active_status = 1 and cash_type = 'credit' and invoice_vendor ='".$arrsystemVendor[$i]."'";
	$totalPaymentDetails = $objPage->getRecordByCustomQueryNew("account_managment",$field="sum(entry_amount) as totamount",$extraSql);		
	$totalincomeindividual = ($totalPaymentDetails["totamount"]) ? $totalPaymentDetails["totamount"] : "0";

?>


<tr><td><strong><?php echo $arrsystemVendor[$i];?> Income</strong></td><td>:</td><td>Rs.<?php echo $totalincomeindividual;?></td></tr>

<?php } ?>
</table>
<br />
<br />

<table cellspacing="5">
<tr><td><strong>Total Income</strong></td><td>:</td><td>Rs.<?php echo $totalIncome;?></td></tr>
<tr><td><strong>Income By Cash</strong></td><td>:</td><td>Rs.<?php echo $totIncomebyCash;?></td></tr>
<tr><td><strong>Income By Cheque</strong></td><td>:</td><td>Rs.<?php echo $totincomebycheque;?></td></tr>
</table>
<br />
<table cellspacing="5">
<tr><td class="highlight"><strong>Total Expense</strong></td><td>:</td><td>Rs.<?php echo $totalExpense;?></td></tr>
</table>
<br />
<table cellspacing="5">
<tr><td class="highlight"><strong>Available Amount</strong></td><td>:</td><td>Rs.<?php echo $totAvailableBal;?></td></tr>
</table>
</div>

<div class="leftblock">
<form method="post" id="extenddeadline" name="extenddeadline" action="index.php?option=com_pos&task=closeaccount">
<table cellspacing="5" width="100%">
<tr><td align="center"><input type="submit"  value="Close Account & Start New"/></td></tr>
</table>
</form>
</div>
<div class="leftblock">
<form method="post" id="downloadreport" name="downloadreport" action="index.php?option=com_pos&task=downaccreport">
<table cellspacing="5" width="100%">
<tr><td align="center"><input type="submit"  value="Download Report"/></td></tr>
</table>
</form>

<div class="leftblock">
<h3>Account Closed For Last Month</h3>
<table cellspacing="5">
<tr><td><strong>Total Income</strong></td><td>:</td><td>Rs.<?php echo $totalIncomeNew;?></td></tr>
<tr><td><strong>Income By Cash</strong></td><td>:</td><td>Rs.<?php echo $totIncomebyCashNew;?></td></tr>
<tr><td><strong>Income By Cheque</strong></td><td>:</td><td>Rs.<?php echo $totincomebychequeNew;?></td></tr>
</table>
<br />
<table cellspacing="5">
<tr><td class="highlight"><strong>Total Expense</strong></td><td>:</td><td>Rs.<?php echo $totalExpenseNew;?></td></tr>
</table>
<br />
<table cellspacing="5">
<tr><td class="highlight"><strong>Available Amount</strong></td><td>:</td><td>Rs.<?php echo $totAvailableBalNew;?></td></tr>
</table>
</div>

<form method="post" id="downloadreport" name="downloadreport" action="index.php?option=com_pos&task=downacclastreport">
<table cellspacing="5" width="100%">
<tr><td align="center"><input type="submit"  value="Last Month Report"/></td></tr>
</table>
</form>

</div>