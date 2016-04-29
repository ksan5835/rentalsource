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
<h3>Service Call Information</h3>
<div align="right" style="float:right;"><input type="button" value="Add New" class="rstpwd"/></div>
<div style="clear:both;height:10px;"></div>
<table id="example" class="display" width="100%">
<thead><th width="5%">S.No</th><th>Name</th><th>Phone</th><th>Executive name</th><th>Service Details</th><th width="15%">Service Date</th><th width="10%">Status</th><th width="10%">Edit</th><th width="10%">Trash</th></thead><tbody>
<?php


@$ServiceLists = $objPage->getServiceLists($cId,$extraquery);
$strTotal =0;
if($ServiceLists)
{
	for($i=0;$i<count(@$ServiceLists);$i++)
	{
		
		echo '<tr>';
		echo '<td>'.($i + 1).'</td>';
		echo '<td>'.$ServiceLists[$i]['client_name'].'</td>';
		echo '<td>'.$ServiceLists[$i]['contact_number'].'</td>';
		echo '<td>'.$ServiceLists[$i]['exe_name'].'</td>';
		echo '<td>'.$ServiceLists[$i]['service_request'].'</td>';
		echo '<td>'.date("d-m-Y",strtotime($ServiceLists[$i]['enquiry_date'])).'</td>';
		echo '<td>'.ucfirst($ServiceLists[$i]['service_status']).'</td>';
		echo '<td align="center"><img src="'.SITE_ROOT.'/templates/mblue/images/edit.jpg" style="height:12px;width:12px;cursor:pointer;" class="edit" datgid='.$ServiceLists[$i]['id'].'  /></td>
		<td><input type= "checkbox" class="intrash" value="'.$ServiceLists[$i]['id'].'" /></td>';
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
		jQuery('#updatedeadline').modal({minHeight:450,minWidth:350});			
	});	
	
	jQuery('.edit').click(function(){		
		
		var uId = jQuery(this).attr("datgid");	
		
		jQuery('#updatedeadline').modal({minHeight:450,minWidth:350});	
		getServiceForm(uId);
				
	});
	
	jQuery('.intrash').click(function(){		
		  if(confirm("Are you sure want to trash this Service?"))
		  {
			  var rId = jQuery(this).val();
			  
			  if(jQuery(this).is(':checked'))
			  {   		
				
				  jQuery.post("index.php?option=com_pos&task=trashservice", { recid: rId  },
				  function(data) {						
					alert("Service moved to trash Successfully");
					window.location.href = window.location.href;										
				  });
				
			  }
		}
	});	

	function getServiceForm(userid)
	{
		jQuery.post("index.php?option=com_pos&task=serviceform", { cid: userid  },
		function(data) {
			jQuery(".ldform").html(data);											
		});
	}
	
</script>
<div id="updatedeadline" style="display:none;">
<form method="post" id="extenddeadline" name="extenddeadline" action="index.php?option=com_pos&task=addnewservice">
<span class="stitle"><h3>Service Call Details</h3></span>
<div class="ldform"></div>
</form>
<script language="javascript">
	getServiceForm(0);
</script>
</div>
<?php include_once(SERVER_ROOT . '/templates/mblue/footer.html'); ?>