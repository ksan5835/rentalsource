<?php
include_once(SERVER_ROOT . '/templates/mblue/header.html');
include_once(SERVER_ROOT . '/lib/userdata.php');
?>

<div class="innerhome">
<h3>Welcome to Rental Systems Admin Panel</h3>

<table width="100%">
<tr><td valign="top">

<ul class="mnav">
<li><a href="index.php?option=com_pos&view=invoice_details"><img src="<?php echo SITE_ROOT;?>/templates/mblue/images/users.jpg" /><br />Invoice</a></li>
<li><a href="index.php?option=com_pos&view=clients"><img src="<?php echo SITE_ROOT;?>/templates/mblue/images/users.jpg" /><br />Clients</a></li>
<li><a href="index.php?option=com_pos&view=new_leads"><img src="<?php echo SITE_ROOT;?>/templates/mblue/images/users.jpg" /><br />New Leads</a></li>
<li><a href="index.php?option=com_pos&view=accounts"><img src="<?php echo SITE_ROOT;?>/templates/mblue/images/users.jpg" /><br />Accounts</a></li>
<li><a href="index.php?option=com_pos&view=users"><img src="<?php echo SITE_ROOT;?>/templates/mblue/images/users.jpg" /><br />Users</a></li>
<li><a href="index.php?option=com_pos&view=service"><img src="<?php echo SITE_ROOT;?>/templates/mblue/images/users.jpg" /><br />Service</a></li>
</ul>

<br />
<div style="clear:both"></div>





<h3>Invoice(s)</h3>

<table width="100%" class="border3">
<tr><th width="5%">S.No</th><th>Client ID</th><th>Organisation</th><th>Client Name</th><th>Status</th><th>View</th></tr>
<?php
$strDate = date('d');
$extrasql="invoice_date >=".$strDate." and invoice_date <=".($strDate + 2);
$clients = $objPage->getClientsLists($extrasql);
if($clients)
{
	for($i = 0; $i < count($clients); $i++)
	{
		$m = date('m');
		$y = date('Y');
		$d = $clients[$i]['invoice_date'];
		
		$invDate = $y.'-'.$m.'-'.$d;
		
		$invDet = $objPage->getInvoiceDetById($clients[$i]['id'],$invDate);
		$status = ($invDet['email_status']) ? ucfirst($invDet['email_status']) : '-';
		$strUrl = 'index.php?option=com_pos&view=invoice&cid='.$clients[$i]['id'];

		if($invDet['payment_status'] == ''){
			echo '<tr><td>'.($i + 1).'</td><td>'.$clients[$i]['client_id'].'</td><td><span>'.$clients[$i]['organisation'].'</span></td><td>'.$clients[$i]['client_name'].'</td><td>'.$status.'</td><td><a href="'.$strUrl.'">View</a></td></tr>';
		}
		
	}
}
else
{
	echo '<tr><td colspan="6">No data found.</td>';
}
?>

</table>

<br />

<h3>Closing Contract(s)</h3>
<table width="100%" class="border3">
<tr><th width="5%">S.No</th><th>Client ID</th><th>Organisation</th><th>Client Name</th><th>End Date</th><th>Status</th><th>View</th></tr>
<?php
$strCDate = date('Y-m-d');
$strN2Date = date('Y-m-d',strtotime("+2 days",strtotime($strCDate)));
$extra="end_date between '".$strCDate."' and '".$strN2Date."' order by end_date asc";

$endClients = $objPage->getClientsLists($extra);
if($endClients)
{
	for($i = 0; $i < count($endClients); $i++)
	{
		$strEnDate = date("d-m-Y",strtotime($endClients[$i]['end_date']));
		echo '<tr><td>'.($i + 1).'</td><td>'.$endClients[$i]['client_id'].'</td><td><span>'.$endClients[$i]['organisation'].'</span></td><td>'.$endClients[$i]['client_name'].'</td><td>'.$strEnDate.'</td><td>--</td><td>--</td></tr>';
	}
}
else
{
	echo '<tr><td colspan="7">No data found.</td>';
}
?>
</table>
<br />


</td>
<td width="30%" valign="top"> 



<?php include_once(SERVER_ROOT . '/templates/mblue/sidemenumyaccount.php'); ?>


 </td>
</tr>
</table>

</div>


<?php
include_once(SERVER_ROOT . '/templates/mblue/footer.html');
?>