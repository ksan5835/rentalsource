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
<h3>New Enquiry Information</h3>
<div align="right" style="float:right;"><input type="button" value="Add New" class="rstpwd"/></div>
<div style="clear:both;height:10px;"></div>
<table id="example" class="display" width="100%">
<thead><th width="5%">S.No</th><th>Name</th><th>Phone</th><th>email</th><th>Requirement</th><th width="10%">Enquiry Date</th><th width="10%">Trash</th></thead><tbody>
<?php


@$leadLists = $objPage->getLeadLists($cId,$extraquery);
$strTotal =0;
if($leadLists)
{
	for($i=0;$i<count(@$leadLists);$i++)
	{
		
		echo '<tr>';
		echo '<td>'.($i + 1).'</td>';
		echo '<td>'.$leadLists[$i]['client_name'].'</td>';
		echo '<td>'.$leadLists[$i]['contact_number'].'</td>';
		echo '<td>'.$leadLists[$i]['contact_email'].'</td>';
		echo '<td>'.$leadLists[$i]['requirements'].'</td>';
		echo '<td>'.date("d-m-Y",strtotime($leadLists[$i]['enquiry_date'])).'</td>';
		echo '<td><input type="checkbox" class="intrash" value="'.$leadLists[$i]['id'].'" /></td>';
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
		jQuery('#updatedeadline').modal({minHeight:380,minWidth:350});			
	});	
	
	jQuery('.edit').click(function(){		
		
		var uId = jQuery(this).attr("datgid");	
		
		jQuery('#updatedeadline').modal({minHeight:380,minWidth:350});	
		getUserForm(uId);
				
	});
	
	jQuery('.intrash').click(function(){		
	  if(confirm("Are you sure want to trash this lead?"))
	  {
		  var rId = jQuery(this).val();
		  
		  if(jQuery(this).is(':checked'))
		  {   		
			  jQuery.post("index.php?option=com_pos&task=trashlead", { recid: rId  },
			  function(data) {						
				alert("Lead moved to trash Successfully");
				window.location.href = window.location.href;										
			  });
			
		  }
	   }
	});	
	
	function getUserForm(userid)
	{
		jQuery.post("index.php?option=com_pos&task=leadform", { cid: userid  },
		function(data) {
			jQuery(".ldform").html(data);											
		});
	}
	
</script>
<div id="updatedeadline" style="display:none;">
<form method="post" id="extenddeadline" name="extenddeadline" action="index.php?option=com_pos&task=addnewlead">
<span class="stitle"><h3>System Details</h3></span>
<div class="ldform"></div>
</form>
<script language="javascript">
	getUserForm(0);
</script>
</div>
<?php include_once(SERVER_ROOT . '/templates/mblue/footer.html'); ?>