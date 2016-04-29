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
					
            }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"iDisplayLength": 10
        });
    });
 </script>
<?php
$cId = @$_REQUEST['cid'];
$cDetails = $objPage->getClientDetailsById($cId); 

	unset($serviceSum);
	$extraSql = "rec_active_status = '1' and cash_type = 'credit'";
	$serviceSum = $objPage->getRecordByServiceTotal($field="sum(entry_amount) as totCount",$extraSql);
	$serviceSumPrice = ($serviceSum) ? $serviceSum["totCount"] : "0";
?>
<div class="innerhome">
<table width="100%">
<tr><td valign="top">
<h3>Service Expense Management</h3>
<div align="right" style="float:right;"><input type="button" value="Add New" class="rstpwd"/></div>
<div style="clear:both;height:25px;"><h4>Total Service Call Income :: Rs.<?php echo $serviceSumPrice; ?></h4></div>
<table id="example" class="display" width="100%">
<thead><th width="5%">S.No</th><th>Description</th><th style="width:15%">Date</th><th style="width:15%">Amount</th><th style="width:15%">Transation Type</th><th>Edit</th></thead><tbody>
<?php

$extraquery = "rec_active_status=1";
@$entryLists = $objPage->getServiceAccEntryLists($extraquery);
$strTotal =0;
if($entryLists)
{
	for($i=0;$i<count(@$entryLists);$i++)
	{
		
		$exDate = date("d-m-Y",strtotime($entryLists[$i]['expense_date']));
		
		echo '<tr>';
		echo '<td>'.($i + 1).'</td>';
		echo '<td>'.$entryLists[$i]['description'].'</td>';
		echo '<td>'.$exDate.'</td>';
		echo '<td>Rs.'.$entryLists[$i]['entry_amount'].'</td>';
		echo '<td>'.$entryLists[$i]['cash_type'].'</td>';
		echo '<td align="center"><img src="'.SITE_ROOT.'/templates/mblue/images/edit.jpg" style="height:12px;width:12px;cursor:pointer;" class="edit" datgid='.$entryLists[$i]['id'].'  /></td>';
		
		/*echo '<td>'.$leadLists[$i]['contact_number'].'</td>';
		echo '<td>'.$leadLists[$i]['contact_email'].'</td>';
		echo '<td>'.$leadLists[$i]['requirements'].'</td>';
		echo '<td>'.date("d-m-Y",strtotime($leadLists[$i]['enquiry_date'])).'</td>';
		echo '<td>View</td>';*/
		echo '</tr>';
	}
		
}
?>
</tbody>
</table>
<br />

</td>
<td width="30%" valign="top"> 

<?php include_once(SERVER_ROOT . '/templates/mblue/sidemenumyaccount.php'); ?>

 </td>
</tr>
</table>

</div>

<script language="javascript">
	 
	 
	jQuery('.rstpwd').click(function(){		
		jQuery('#updatedeadline').modal({minHeight:520,minWidth:350});			
	});	
	
	jQuery('.edit').click(function(){		
		
		var uId = jQuery(this).attr("datgid");
		jQuery('#updatedeadline').modal({minHeight:520,minWidth:350});	
		getUserForm(uId);
				
	});
	
	function getUserForm(userid)
	{
		jQuery.post("index.php?option=com_pos&task=accountformservice", { cid: userid  },
		function(data) {
			jQuery(".ldform").html(data);											
		});
	}
	
</script>
<div id="updatedeadline" style="display:none;">
<form method="post" id="extenddeadline" name="extenddeadline" action="index.php?option=com_pos&task=addnewaccservice">
<span class="stitle"><h3>Service Account Entry</h3></span>
<div class="ldform"></div>
</form>
<script language="javascript">
	getUserForm(0);
</script>
</div>
<?php include_once(SERVER_ROOT . '/templates/mblue/footer.html'); ?>