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
			"iDisplayLength": 25
        });
    });
 </script>
<div class="innerhome">
<table width="100%">
<tr><td valign="top">
<h3>On Office Systems</h3>
<div class="ctlmenu">
<table width="50%">
<?php 
@$rentalCategory = $objPage->getRentalCategory();
$totCat = count($rentalCategory);	
for($i=0;$i<$totCat;$i++){
$sysCategory = $rentalCategory[$i]['category_meta'];

$extraSql = "system_type='".$sysCategory."'";
$countRec = $objPage->getRecordByCustomQuery("onoffice_systems","sum(system_qty) as totQty",$extraSql);

$extraSql2 = "system_type='".$sysCategory."' and available_status='yes'";
$countRecAvail = $objPage->getRecordByCustomQuery("onoffice_systems","sum(system_qty) as totQty",$extraSql2);
if($countRec['totQty']){	
?>
<tr>
<td><strong>Total <?php echo $rentalCategory[$i]['rental_category'];?></strong></td><td><?php echo $countRec['totQty'];?></td>
<?php if($countRecAvail['totQty']){ ?>
<td><strong>Available <?php echo $rentalCategory[$i]['rental_category'];?></strong></td><td><?php echo $countRecAvail['totQty'];?></td>
<?php } else { ?>
<td>&nbsp;</td><td>&nbsp;</td>
<?php } ?>
</tr>

<?php } } ?>
</tr>
</table>
</div>

<h3>System Information</h3>
<div align="right" style="float:right;"><input type="button" value="Add New" class="rstpwd"/></div>
<div style="clear:both;height:10px;"></div>
<table id="example" class="display" width="100%">
<thead><th width="5%">S.No</th><th>System Type</th><th>Qty</th><th>Description</th><th>Available</th><th width="10%">Last Update</th><th width="10%">View / Edit</th></thead><tbody>
<?php

@$clientSysDet = $objPage->getOnofficeSys();
$strTotal =0;
if($clientSysDet)
{
	for($i=0;$i<count(@$clientSysDet);$i++)
	{
		$strQty = $clientSysDet[$i]['system_qty'];
		$strlastDate = date("d-m-Y", strtotime($clientSysDet[$i]['last_update_date']));
		
		echo '<tr><td>'.($i + 1).'</td><td>'.$clientSysDet[$i]['system_type'].'</td><td>'.$strQty.'</td><td>'.$clientSysDet[$i]['short_description'].'</td><td>'.$clientSysDet[$i]['available_status'].'</td><td>'.$strlastDate.'</td><td align="center"><img src="'.SITE_ROOT.'/templates/mblue/images/edit.jpg" style="height:12px;width:12px;cursor:pointer;" class="edit" datgid="'.$clientSysDet[$i]['id'].'"  /></td></tr>';
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
		jQuery('#updatedeadline').modal({minHeight:380,minWidth:350});			
	});	
	
	jQuery('.edit').click(function(){		
		
		var uId = jQuery(this).attr("datgid");	
		
		jQuery('#updatedeadline').modal({minHeight:380,minWidth:350});	
		getUserForm(uId);
				
	});
	
	function getUserForm(userid)
	{
		jQuery.post("index.php?option=com_pos&task=onOfficeSysForm", { cid: userid  },
		function(data) {
			jQuery(".ldform").html(data);											
		});
	}
	
</script>
<div id="updatedeadline" style="display:none;">
<form method="post" id="extenddeadline" name="extenddeadline" action="index.php?option=com_pos&task=saveOnofficeSys">
<span class="stitle"><h3>System Details</h3></span>
<div class="ldform"></div>
</form>
<script language="javascript">
	getUserForm(0);
</script>
</div>
<?php include_once(SERVER_ROOT . '/templates/mblue/footer.html'); ?>