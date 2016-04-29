<script type="text/javascript" language="javascript"   >
jQuery(document).ready(function() {

$('.user-img a').poshytip({
				className: 'tip-twitter',
				showTimeout: 1,
				alignTo: 'target',
				alignX: 'center',
				offsetY: 5,
				allowTipHover: false,
				fade: false,
				slide: false
			});

});
</script>
<div class="user-img"><a href="#" title="<?php echo $userFullName;?>"><img src="<?php echo SITE_ROOT."/".$userSmallThumb; ?>" /></a></div>
<div class="user-text"><span><?php echo $userShortName;?></span></div>
<div class="user-ratings">
<div class="user-star">
<ul>
  <li><img src="<?php echo SITE_ROOT; ?>/templates/mblue/images/star-icon1.png"</li>
   <li><img src="<?php echo SITE_ROOT; ?>/templates/mblue/images/star-icon1.png"</li>
    <li><img src="<?php echo SITE_ROOT; ?>/templates/mblue/images/star-icon1.png"</li>
     <li><img src="<?php echo SITE_ROOT; ?>/templates/mblue/images/star-icon1.png"</li>
      <li><img src="<?php echo SITE_ROOT; ?>/templates/mblue/images/star-icon1.png"</li>
</ul>
</div>
</div>
<div class="user-ratings1">
<div class="user-star1">
<ul>
  <li>
  <div class="user-update" align="center"><h3>7</h3></div>
  <div class="user-update-text" align="center">Views</div>
  </li>
   <li><div class="user-update" align="center"><h3><?php echo $userTotExp;?></h3></div>
  <div class="user-update-text" align="center">Exp</div></li>
    <li><div class="user-update" align="center"><h3><?php echo $userAge;?></h3></div>
  <div class="user-update-text" align="center">Age</div></li>
</ul>
</div>

</div>