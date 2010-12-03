<div class="module" id="module-<?=$module['id']?>">

<!-- START MODULE NAV -->
<div class="module_nav">
<a class='back' href='#' onclick='prev(<?=$module['id']?>)'>Back</a>
<a class='next' href='#' onclick='next(<?=$module['id']?>)'>Next</a>
</div>
<!-- END MODULE NAV -->

<div id="vis-<?=$module['id']?>" class="vis"></div>

<ul class="module_subnav">
<li><a href='#' onclick='goto_option("members")'><img src="/system/application/img/subnav/group.png"/>Members</a></li>
<li><a href='#' onclick='goto_option("details")'><img src="/system/application/img/subnav/magnify.png"/>Details</a></li>
<li><a href='#' onclick='goto_option("options")'><img src="/system/application/img/subnav/gear.png"/>Options</a></li>
<li><a href='#' onclick='goto_option("stats")'><img src="/system/application/img/subnav/linechart.png"/>Stats</a></li>
</ul>
<div id="members"><p><b>Members:</b> <?=$num_members?></p></div>
<div id="details"><p><b><?=$module['name']?>: </b><?=$module['description']?></p></div>
<div id="options"><p><b>Options:</b> User settings for a campaign go here.</p></div>
<div id="stats">
<p><b>Stats:</b><br/>
<b>Our Total:</b> $<?=$total_spend?></b><br/>
<b>My Total:</b> $$my_spend<br/>
<b>Avg/Visit:</b> $<?=$avg_spend_per_visit?></b><br/>
<b>Avg/Interval:</b> $<?=$avg_spend_per_interval?></b><br/>
<b>Avg/User:</b> $<?= ($total_spend && $num_members) ? round(($total_spend/$num_members),2) : 0; ?></p>
</div>

</div>

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

   // BIND INTERACTIVITY FUNCTIONS
   $("#vis-<?=$module['id']?>").bind("plotclick", function (event, pos, item) {
       //alert("You clicked at " + pos.x + ", " + pos.y);
       if (item) {
	highlight(item.series, item.datapoint);
       }
     });
   
   //tooltip function
   function showTooltip(x, y, contents, areAbsoluteXY) {
     var rootElt = 'body';
     $('<div id="tooltip" class="tooltip-with-bg">' + contents + '</div>').css( {
       position: 'absolute',
	   display: 'none',
	   'z-index':'1010',
	   top: y,
	   left: x
	   }).prependTo(rootElt).show();
   }
                
   //add tooltip event
   $("#placeholder").bind("plothover", function (event, pos, item) {
       alert("h3llo");
       /*
       if (item) {
	 if (previousPoint != item.datapoint) {
	   previousPoint = item.datapoint;

	   //delete previous tooltip
	   $('.tooltip-with-bg').remove();

	   var x = item.datapoint[0];

	   //All the bars concerning a same x value must display a tooltip with this value and not the shifted value
	   if(item.series.bars.order){
	     for(var i=0; i < item.series.data.length; i++){
	       if(item.series.data[i][3] == item.datapoint[0])
		 x = item.series.data[i][0];
	     }
	   }

	   var y = item.datapoint[1];

	   showTooltip(item.pageX+5, item.pageY+5,x + " = " + y);

	 }
       }
       else {
	 $('.tooltip-with-bg').remove();
	 previousPoint = null;
       }*/
     });
});
</script>
