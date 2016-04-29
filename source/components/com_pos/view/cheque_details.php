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
?>
<div class="innerhome">
<table width="100%">
<tr><td valign="top">
<h3>Cheque Details</h3>
<div align="right" style="float:right;"><input type="button" value="Add New" class="rstpwd"/></div>&nbsp;&nbsp;
<div style="clear:both;height:10px;"></div>
<table id="example" class="display" width="100%">
<thead><th width="5%">S.No</th><th>Client Name</th><th>bank Name</th><th style="width:15%">Date</th><th style="width:15%">Amount</th><th style="width:15%">Payment Type</th><th>Edit</th></thead><tbody>
<?php

$extraquery = "rec_active_status=1 and payment_type='cheque'";
@$entryLists = $objPage->getChkEntryLists($extraquery);
$strTotal =0;
if($entryLists)
{
	for($i=0;$i<count(@$entryLists);$i++)
	{
		
		$exDate = date("d-m-Y",strtotime($entryLists[$i]['cheque_date']));
		
		echo '<tr>';
		echo '<td>'.($i + 1).'</td>';
		echo '<td>'.$entryLists[$i]['client_name'].'</td>';
		echo '<td>'.$entryLists[$i]['bank_name'].'</td>';
		echo '<td>'.$exDate.'</td>';
		echo '<td>Rs.'.$entryLists[$i]['entry_amount'].'</td>';
		echo '<td>'.$entryLists[$i]['payment_status'].'</td>';
		echo '<td align="center"><img src="'.SITE_ROOT.'/templates/mblue/images/edit.jpg" style="height:12px;width:12px;cursor:pointer;" class="edit" datgid='.$entryLists[$i]['id'].'  /></td>';
		echo '</tr>';
	}
		
}
?>
</tbody>
</table>
<br />

</td>
<td width="30%" valign="top"> 

<?php include_once(SERVER_ROOT . '/templates/mblue/sidemenuaccounts.php'); ?>

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
		jQuery.post("index.php?option=com_pos&task=chequeform", { cid: userid  },
		function(data) {
			jQuery(".ldform").html(data);											
		});
	}
	
</script>
<div id="updatedeadline" style="display:none;">
<form method="post" id="extenddeadline" name="extenddeadline" action="index.php?option=com_pos&task=addnewchequeentry">
<span class="stitle"><h3>New Cheque Entry</h3></span>
<div class="ldform"></div>
</form>
<script language="javascript">
	getUserForm(0);
</script>
</div>
<?php include_once(SERVER_ROOT . '/templates/mblue/footer.html'); ?>