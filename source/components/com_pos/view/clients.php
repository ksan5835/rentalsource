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
	
	function download_report()
	{
		$('#frmfilete').attr('action', 'index.php?option=com_pos&task=dwlreport');
		$('#frmfilete').submit();
	}
	
	function filter_report()
	{
		$('#frmfilete').attr('action', 'index.php?option=com_pos&view=clients');
		$('#frmfilete').submit();
	}
	
 </script>
<div class="innerhome">
<table width="100%">
<tr><td valign="top">
<h3>Clients</h3>
<div class="ctlmenu">
<p>Manage Clients add new , edit , delete Clients</p>
</div>
<br />





<?php

if($_POST)
{
		$stDay = "";
		$endDay = "";	
		$stDay = $_POST['filstartdate'];
		$endDay = $_POST['filenddate'];
		$extrasql = " invoice_date between ".$stDay." and ".$endDay;	
	
}


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
		
		$strUrl = 'index.php?option=com_pos&view=client_view&cid='.$clients[$i]['id'];
		$strUrl1 = 'index.php?option=com_pos&view=addclient&cid='.$clients[$i]['id'];
		$strClientLists .= '<tr><td>'.($i + 1).'</td><td><span>'.$clients[$i]['organisation']." - ".$clients[$i]['client_name'].'</span></td><td>'.$clients[$i]['mobileno'].'</td><td align="right">'.$desktopcountPrice.'</td><td>'.$clients[$i]['invoice_date'].'</td><td><a href="'.$strUrl.'">View</a><td align="center"><a href="'.$strUrl1.'&edit=1"><img src="'.SITE_ROOT.'/templates/mblue/images/edit.jpg" style="height:12px;width:12px;cursor:pointer;" /></a></td>';
		if(@$_SESSION['srole'] == "admin"){
		 $strClientLists .=  '<td align="center"><img src="'.SITE_ROOT.'/templates/mblue/images/delete.jpg" style="height:12px;width:12px;cursor:pointer;" class="delete" datgid="'.$clients[$i]['id'].'" /></td></tr>';
		}
	}
}
?>

<?php 
$strInvoiceDate = "";

for($i=1;$i<=30;$i++)
{
	$strSelected = ($stDay == $i) ? 'selected="selected"' : "";
	$stroOptStDate .= '<option value="'.$i.'" '.$strSelected.'>'.$i.'</option>';
	
	$strSelected = ($endDay == $i) ? 'selected="selected"' : "";
	$stroOptEndDate .= '<option value="'.$i.'" '.$strSelected.'>'.$i.'</option>';
}


$strInvoiceStartDate = "<select name='filstartdate'>".$stroOptStDate."</select>";
$strInvoiceEndDate = "<select name='filenddate'>".$stroOptEndDate."</select>";
?>


<form name="frmfilete" id="frmfilete" method="post">
<table >
<tr>
<td>Filter: Invoice Date: <?php echo $strInvoiceStartDate;?> and <?php echo $strInvoiceEndDate;?> </td>
<td><input type="button" value="Filter" name="btn_filter"  onclick="javascript:filter_report();"/></td>
<td><input type="button" value="Download Report" name="btn_report" onclick="javascript:download_report();" /></td>
<td>Total Rental Income: <strong>Rs.<?php echo $strTotalIncome;?></strong></td>
</tr>
</table>
</form>
<br />


<div align="right" style="float:right;"><a class="rstpwd" style="text-decoration:none; padding:10px 5px;" href="index.php?option=com_pos&view=addclient">Add New</a></div>
<div style="clear:both;height:10px;"></div>

<table id="example" class="display" width="100%">
<thead><th width="5%">S.No</th><th>Organisation</th><th width="10%">Phone No</th><th width="10%">Rental</th><th width="10%">Invoice Day</th><th width="5%">Systems</th><th width="10%">View / Edit</th><th>Trash</th></thead><tbody>
<?php echo $strClientLists;?>
</tbody>
</table>


</td>
<td width="30%" valign="top"> 

<?php include_once(SERVER_ROOT . '/templates/mblue/sidemenumyaccount.php'); ?>

 </td>
</tr>
</table>

</div>

<script language="javascript">
/*	
	jQuery('.rstpwd').click(function(){		
		jQuery('#updatedeadline').modal({minHeight:300,minWidth:450});			
	});	*/
	
	jQuery('.delete').click(function(){		
		if(confirm("Are you sure want to delete this location?"))
		{
			var rId = jQuery(this).attr("datgid");
			jQuery.post("index.php?option=com_pos&task=clientdelete", { recid: rId  },
			function(data) {						
				alert("Record Deleted Successfully");
				window.location.href = window.location.href;										
			});
		}
	});	

	
	/*jQuery('.edit').click(function(){		
		
		var uId = jQuery(this).attr("datgid");	
		jQuery('#updatedeadline').modal({minHeight:300,minWidth:450});	
		getUserForm(uId);
				
	});
	
	function getUserForm(userid)
	{
		jQuery.post("index.php?option=com_pos&task=clientform", { cid: userid  },
		function(data) {
			jQuery(".ldform").html(data);											
		});
	}*/
	
</script>
<div id="updatedeadline" style="display:none;">
<form method="post" id="extenddeadline" name="extenddeadline" action="index.php?option=com_pos&task=addClient">
<span class="stitle"><h3>Add New Client</h3></span>
<div class="ldform"></div>
</form>
<script language="javascript">
	getUserForm(0);
</script>
</div>
<?php include_once(SERVER_ROOT . '/templates/mblue/footer.html'); ?>