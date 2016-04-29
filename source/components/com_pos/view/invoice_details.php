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
<table width="100%">
<tr>
<td width="50%"><h3>Invoice List</h3></td>
<td align="right"><a href="index.php?option=com_pos&view=new_invoice"><h3>New Invoice</h3></a></td>
</tr>
</table>

<div class="ctlmenu">
<p>Manage Client's Invoice</p>
</div>

<?php
	
	@$seStatus  = $_REQUEST['status'];
	$arrStatus  = array('pending','paid','hold','archive','partial');
	$totCount = count($arrStatus);
		
?>

<div align="right" style="float:right;">
Filter: 
<select onchange="javascript:changestatus(this.value)">
<?php for($i=0;$i<$totCount;$i++){  ?>
<?php $selected = ($seStatus == $arrStatus[$i]) ? 'selected = "selected"' : ""; ?>
<option value="<?php echo $arrStatus[$i];?>" <?php echo $selected;?>><?php echo ucfirst($arrStatus[$i]);?></option>
<?php } ?>
</select>

</div>
<div style="clear:both;height:10px;"></div>
<table id="example" class="display" width="100%">
<thead><th width="5%">S.No</th><th width="10%">Client ID</th><th>Organisation</th><th width="15%">Invoice Period</th><th width="10%">Invoice Amount</th><th width="5%">Invoice_Date</th><th>Payment Status</th><th width="10%">View</th><th width="10%">Trash</th></thead><tbody>
<?php

$extrasql = ($seStatus) ? " payment_status ='".$seStatus."'" : "";
@$invoiceLists = $objPage->getInvoiceLists($extrasql);



if($invoiceLists)
{
	for($i=0;$i<count(@$invoiceLists);$i++)
	{
		
		$exSql = " id = ".$invoiceLists[$i]['client_id'];
		$clientDetails = $objPage->getRecordByCustomQuery("client","client_name,client_id,organisation",$exSql);		
		$clientId = $clientDetails['client_id'];
		if($invoiceLists[$i]['client_id']){
			$clientname = $clientDetails['client_name']." - ".$clientDetails['organisation'];
		}else{					
			$ex_invoice_indetails = explode(':',$invoiceLists[$i]['invoice_in_details']);
			$clientname = $ex_invoice_indetails[0];	
			$clientId = 'CRS00'.$invoiceLists[$i]['id'];
		}
		
		

		echo '<tr>';
		echo '<td>'.($i + 1).'</td>';
		echo '<td>'.$clientId.'</td>';
		echo '<td>'.$clientname.'</td>';
		echo '<td>'.$invoiceLists[$i]['invoice_period'].'</td>';
		echo '<td>'.$invoiceLists[$i]['invoice_amount'].'</td>';
		echo '<td>'.$invoiceLists[$i]['invoice_date'].'</td>';
		echo '<td>'.ucfirst($invoiceLists[$i]['payment_status']).'</td>';
		if($invoiceLists[$i]['client_id'] == 0){
			echo '<td><a href="index.php?option=com_pos&view=invoice&rid='.$invoiceLists[$i]['id'].'">View</a></td>';
		}else{
			echo '<td><a href="index.php?option=com_pos&view=invoice&cid='.$invoiceLists[$i]['client_id'].'&vid='.$invoiceLists[$i]['id'].'">View</a></td>';
		}
		
		echo '<td><input type= "checkbox" class="intrash" value="'.$invoiceLists[$i]['id'].'" /></td>';
		echo '</tr>';
	}
}
?>
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


	jQuery('.intrash').click(function(){		
	  if(confirm("Are you sure want to tash this invoice?"))
	  {
		  var rId = jQuery(this).val();
		  
		  if(jQuery(this).is(':checked'))
		  {   		
			
			  jQuery.post("index.php?option=com_pos&task=trashinvoice", { recid: rId  },
			  function(data) {						
				alert("Invoice moved to trash Successfully");
				window.location.href = window.location.href;										
			  });
			
		  }
		  
		  
		  /*var rId = jQuery(this).attr("datgid");
		  jQuery.post("index.php?option=com_pos&task=clientdelete", { recid: rId  },
		  function(data) {						
			alert("Record Deleted Successfully");
			window.location.href = window.location.href;										
		  });*/
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