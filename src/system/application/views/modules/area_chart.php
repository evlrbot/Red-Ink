<div class="module" id="module-<?=$module['id']?>">

<!-- START MODULE NAV -->
<div class="module_nav">
<a class='back' href='#' onclick='prev(<?=$module['id']?>)'>Back</a>
<a class='next' href='#' onclick='next(<?=$module['id']?>)'>Next</a>
</div>
<!-- END MODULE NAV -->

<!-- START VIS -->
<div id="vis-<?=$module['id']?>" class="vis"></div>
<!-- END VIS -->

<!-- START SUB NAV -->
<ul class="module_subnav">
<li><a href='#' onclick='return goto_option("members")'><img src="/system/application/img/subnav/group.png"/>Members</a></li>
<li><a href='#' onclick='return goto_option("details")'><img src="/system/application/img/subnav/magnify.png"/>Details</a></li>
<li><a href='#' onclick='return goto_option("options")'><img src="/system/application/img/subnav/gear.png"/>Options</a></li>
<li><a href='#' onclick='return goto_option("stats")'><img src="/system/application/img/subnav/linechart.png"/>Stats</a></li>
<li><a href='#' onclick='return goto_option("share")'><img src="/system/application/img/subnav/linechart.png"/>Share</a></li>
</ul>
<!-- END SUB NAV -->

<!-- START OPTIONS -->
<div class="option details"><p><b><?=$module['name']?>: </b><?=$module['description']?></p></div>
<div class="option members">
<p><b>Members:</b> <?=$num_members?></p>
<ol>
<?php
foreach($members as $member) {
  $username = explode('@',$member['email']);
  echo "<li>$username[0]</li>\n";
}
?>
</ol>
</div>
<div class="option options"><p><b>Options:</b> User settings for a campaign go here.</p></div>
<div class="option stats">
<p><b>Stats:</b><br/>
<b>Our Total:</b> $<?=$total_spend?><br/>
<b>My Total:</b> $$my_spend<br/>
<b>Avg/Visit:</b> $<?=$avg_spend_per_visit?><br/>
<b>Avg/Interval:</b> $<?=$avg_spend_per_interval?><br/>
<b>Avg/User:</b> $<?= ($total_spend && $num_members) ? round(($total_spend/$num_members),2) : 0; ?></p>
</div>
<div class="option share">
<p><b>E-mail to a friend:</b></p>
<form><input type="button" onClick="invite_popup()" value="Invite Friends"></form>

<p><b>Embed Code:</b></p>
<textarea cols="80" rows="2">
<iframe src="<?=site_url("embed/index/$module[id]");?>" width="100%" height="500px"></iframe>
</textarea>

<p><b>Embed Preview:</b></p>
<iframe src="<?=site_url("embed/index/$module[id]");?>" width="100%" height="500px"></iframe>
</div>
<!-- END OPTIONS -->

</div>
<!-- END MODULE -->

<script id="source" language="javascript" type="text/javascript">
$(function () {
   var options = {
      series: { <?php if($module['stacked'] == "t") { echo "stack: 0,"; } ?>
		lines: { show: true, fill:0.1, steps: false }, points: { show: true } },
      xaxis: { mode: "time", timeformat: '%b' },
      yaxis: { tickFormatter: function(v,axis) {return '$'+v.toFixed(axis.tickDecimals)} },
      grid: { clickable:true, hoverable:true, autoHighlight:true }
   };
   var data = <?php echo $json ?>;  
   $.plot($("#vis-<?=$module['id'] ?>"), data, options);
});
</script>
