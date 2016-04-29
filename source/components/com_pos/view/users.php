<?php
include_once(SERVER_ROOT . '/templates/mblue/header.html');
include_once(SERVER_ROOT . '/lib/userdata.php');
?>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#example').dataTable({
            "sPaginationType": "full_numbers","sDom": '<"#example"flipt"ip>', "aoColumnDefs": [{ "bSortable": false, "aTargets": [0
                    ]
            }]
        });
    });
 </script>
<div class="innerhome">
<h3>Welcome to Property Admin Panel</h3>

<table width="100%">
<tr><td valign="top">
<h3>Users</h3>
<div class="ctlmenu">
<p>Manage Users add new , edit , delete Users</p>
</div>

<div align="right" style="float:right;"><input type="button" value="Add New" class="rstpwd"/></div>
<div style="clear:both;height:10px;"></div>
<table id="example" class="display" width="100%">
<thead><th width="5%">S.No</th><th>Email</th><th width="10%">Active</th><th width="10%">Edit</th><th width="10%">Delete</th></thead><tbody>
<?php

@$users = $objPage->getUsersLists();

for($i=0;$i<count(@$users);$i++)
{
	
	$chkStatus = ($users[$i]['active_status'] == 1) ? "checked='checked'" : "";
	
	echo '<tr><td>'.($i + 1).'</td><td><span id="loc_'.$users[$i]['id'].'" >'.$users[$i]['email'].'</span></td><td align="center"><input type="checkbox" '.$chkStatus.' class="active" datgid="'.$users[$i]['id'].'" /></td><td align="center"><img src="'.SITE_ROOT.'/templates/mblue/images/edit.jpg" style="height:12px;width:12px;cursor:pointer;" class="edit" datgid="'.$users[$i]['id'].'"  /></td><td align="center"><img src="'.SITE_ROOT.'/templates/mblue/images/delete.jpg" style="height:12px;width:12px;cursor:pointer;" class="delete" datgid="'.$users[$i]['id'].'" /></td></tr>';
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
	
	jQuery('.rstpwd').click(function(){		
		jQuery('#updatedeadline').modal({minHeight:280,minWidth:300});			
	});	
	
	jQuery('.delete').click(function(){		
		if(confirm("Are you sure want to delete this location?"))
		{
			var rId = jQuery(this).attr("datgid");
			jQuery.post("index.php?option=com_pos&task=userdelete", { recid: rId  },
			function(data) {						
				alert("Record Deleted Successfully");
				window.location.href = window.location.href;										
			});
		}
	});	
	
	jQuery('.active').click(function(){	
		
		var dispVal = "0";
		var rId = jQuery(this).attr("datgid");
		
		if($(this).is(':checked')){		
			dispVal = "1";
		}
		
		jQuery.post("index.php?option=com_pos&task=usershowupdate", { recid: rId , sStatus: dispVal  },
		function(data) {						
			alert("Record Saved Successfully");											
		});
	
	});	
	
	jQuery('.edit').click(function(){		
		
		var uId = jQuery(this).attr("datgid");	
		
		jQuery('#updatedeadline').modal({minHeight:280,minWidth:450});	
		getUserForm(uId);
				
	});
	
	function getUserForm(userid)
	{
		jQuery.post("index.php?option=com_pos&task=userform", { uid: userid  },
		function(data) {
			jQuery(".ldform").html(data);											
		});
	}
	
</script>
<div id="updatedeadline" style="display:none;">
<form method="post" id="extenddeadline" name="extenddeadline" action="index.php?option=com_pos&task=adduser">
<span class="stitle"><h3>Add New User</h3></span>
<div class="ldform"></div>
</form>
<script language="javascript">
	getUserForm(0);
</script>
</div>
<?php include_once(SERVER_ROOT . '/templates/mblue/footer.html'); ?>