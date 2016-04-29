<?php
include_once(SERVER_ROOT . '/templates/mblue/header.html');
include_once(SERVER_ROOT . '/lib/userdata.php');
?>
<script language="javascript">
	jQuery(document).ready(function(){
	jQuery("#extenddeadline").validationEngine({binded: false});	
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
	
	function changestatus(selValue)
	{
		window.location = "index.php?option=com_pos&view=invoice_details&status="+selValue;
	}
	
 </script>
<div class="innerhome">
<table width="100%">
<tr><td valign="top">
<h3>New Invoice</h3>

<div class="ctlmenu">
<p>Manage Client's Invoice</p>
</div>

<?php

$m = date('M');
$y = date('Y');
$d = date('d');

$strInvDate = $d.'-'.$m.'-'.$y;
$strInvNo = rand().date('m').$y;

?>
<form method="post" id="frmAddClient" name="frmAddClient" action="index.php?option=com_pos&view=invoice">
<table width="100%">
<tr><td width="20%"><b>Bill To</b></td><td><input type="text" name="billto" size="50" /></td></tr>
<tr><td width="20%"><b>Address</b></td><td><input type="text" name="billtoaddress" size="50" /></td></tr>
<tr><td width="20%"><b>Contact No</b></td><td><input type="text" name="billcontactno" size="50" /></td></tr>
<tr><td width="20%"><b>Email</b></td><td><input type="text" name="billemail" size="50" /></td></tr>
<tr><td width="20%"><b>Invoice No</b></td><td><?php echo $strInvNo;?><input type="hidden" value="<?php echo $strInvNo;?>" name="billinvoiceno" size="50" /></td></tr>
<tr><td width="20%"><b>Period</b></td><td><input type="text" name="invoiceperiod" size="50" /></td></tr>
<tr><td width="20%"><b>Invoice Date</b></td><td><?php echo $strInvDate;?><input type="hidden" value="<?php echo $strInvDate;?>" name="invoicedate" size="50" /></td></tr>
<tr><td width="20%"><b>Terms Of Payment</b></td><td><input type="text" name="billtypepayment" size="50" /></td></tr>
<tr><td colspan="2" align="right"><input type="button" name="btn_addnew" class="addnewrow" value="Add New Row" /></td></tr>
<tr><td colspan="2">

<table width="100%" id="loaditems">
<tr><th>System Details / Description</th><th>Unit Count</th><th>Unit Price</th></tr>
</table>
<input type="hidden" name="tot_system" id="tot_system" value="0" />

</td>
</tr>
<tr><td colspan="2" align="center"><input type="submit" name="btn_newinvoice" value="Submit" /></td></tr>
</table>
</form>
<script language="javascript">


jQuery('.addnewrow').on('click', function(e) {
		//$("#paycustomfields").append(response);
		var totCount = jQuery("#tot_system").val();	
		totCount = parseInt(totCount) + 1;
		var rowText = "<tr><td><input type='text' name='sys_desc_"+ totCount +"' size='50' /><td><input type='text' name='sys_unit_"+ totCount +"' size='15' /></td></td><td><input type='text' name='sys_unit_price_"+ totCount +"' size='15' /></td></td></td></tr>";
		jQuery("#loaditems").append(rowText);	
		jQuery("#tot_system").val(totCount);
				
	});	

</script>
<div style="clear:both;height:10px;"></div>


</td>
<td width="30%" valign="top"> 

<?php include_once(SERVER_ROOT . '/templates/mblue/sidemenumyaccount.php'); ?>

 </td>
</tr>
</table>

</div>


<?php include_once(SERVER_ROOT . '/templates/mblue/footer.html'); ?>