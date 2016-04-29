<?php
if((@$_SESSION['username'] != "") && (@$_SESSION['password'] != ""))
	{
$unreadmessages = $objPage->getUserMaintainDetails();


if($unreadmessages)
{
$totCount = count($unreadmessages);
$notifystr = "<ul>";
for($i=0;$i<count($unreadmessages);$i++)
{
	$notifystr .= '<li><a href="'.SITE_ROOT.'/index.php?option=com_pos&view=view_email_details&eid=1&recid='.$unreadmessages[$i]['id'].'">'.$unreadmessages[$i]['area_description']."</a></li>";
}
$notifystr .= "</ul>";
?>
<script language="javascript" type="text/javascript">
	jQuery.notify({
		inline: true,
		html: '<h3>(<?php echo $totCount;?>) Unread Report Messages</h3><p><?php echo $notifystr;?>.</p>'
	}, 15000);
</script>
<?php
}

}

?>
