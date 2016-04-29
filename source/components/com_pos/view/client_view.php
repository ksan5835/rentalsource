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
$cId = $_REQUEST['cid'];
$cDetails = $objPage->getClientDetailsById($cId); 
?>
<div class="innerhome">
<table width="100%">
<tr><td valign="top">
<h3>Clients</h3>
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

<h3>System Information</h3>
<div align="right" style="float:right;"><input type="button" value="Add New" class="rstpwd"/></div>
<div style="clear:both;height:10px;"></div>
<table id="example" class="display" width="100%">
<thead><th width="5%">S.No</th><th>System Type</th><th>Qty</th><th>Unit Rent</th><th>Sub Total</th><th width="10%">Last Update</th><th width="10%">View / Edit</th><th width="10%">Delete</th></thead><tbody>
<?php

$extraquery = "rental_status='yes'";
@$clientSysDet = $objPage->getClientSysDetails($cId,$extraquery);
$strTotal =0;
if($clientSysDet)
{
	for($i=0;$i<count(@$clientSysDet);$i++)
	{
		$strUnitRent = $clientSysDet[$i]['unit_rent'];
		$strQty = $clientSysDet[$i]['system_qty'];
		$strSubTot = ($strUnitRent * $strQty);
		$strTotal = $strTotal + $strSubTot;
		$strlastDate = date("d-m-Y", strtotime($clientSysDet[$i]['last_update_date']));
		
		echo '<tr><td>'.($i + 1).'</td><td>'.$clientSysDet[$i]['system_type'].' - '.$clientSysDet[$i]['short_description'].'</td><td>'.$strQty.'</td><td>'.$strUnitRent.'</td><td>'.number_format($strSubTot,2).'</td><td>'.$strlastDate.'</td><td align="center"><img src="'.SITE_ROOT.'/templates/mblue/images/edit.jpg" style="height:12px;width:12px;cursor:pointer;" class="edit" datgid="'.$clientSysDet[$i]['id'].'"  /></td><td align="center"><img src="'.SITE_ROOT.'/templates/mblue/images/delete.jpg" style="height:12px;width:12px;cursor:pointer;" class="delete" datgid="'.$clientSysDet[$i]['id'].'" /></td></tr>';
	}
	//echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Total</td><td>'.number_format($strTotal,2).'</td><td>&nbsp;</td></tr>';
	
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

	jQuery('.delete').click(function(){		
		if(confirm("Are you sure want to delete this system details?"))
		{
			var rId = jQuery(this).attr("datgid");
			jQuery.post("index.php?option=com_pos&task=systemdelete", { recid: rId  },
			function(data) {						
				alert("Record Deleted Successfully");
				window.location.href = window.location.href;										
			});
		}
	});	
	
	jQuery('.rstpwd').click(function(){		
		jQuery('#updatedeadline').modal({minHeight:380,minWidth:350});			
	});	
	
	jQuery('.edit').click(function(){		
		
		var uId = jQuery(this).attr("datgid");	
		
		jQuery('#updatedeadline').modal({minHeight:380,minWidth:350});	
		getUserForm(uId);
				
	});
	
	function getUserForm(userid)
	{
		jQuery.post("index.php?option=com_pos&task=systemform", { cid: userid  },
		function(data) {
			jQuery(".ldform").html(data);											
		});
	}
	
</script>
<div id="updatedeadline" style="display:none;">
<form method="post" id="extenddeadline" name="extenddeadline" action="index.php?option=com_pos&task=addupdateSysInfo">
<span class="stitle"><h3>System Details</h3></span>
<div class="ldform"></div>
<input type="hidden" name="cId" value="<?php echo $cId; ?>" />
</form>
<script language="javascript">
	getUserForm(0);
</script>
</div>
<?php include_once(SERVER_ROOT . '/templates/mblue/footer.html'); ?>