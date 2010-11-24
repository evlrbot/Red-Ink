<div class="module" id="module-<?=$module['id']?>">
<div id="vis-<?=$module['id']?>" class="vis"></div>
<? //include('stats.php'); ?>

<!-- START MODULE NAV -->
<div class="module_nav">
<a class='back' href='#' onclick='prev(<?=$module['id']?>)'><img src="/system/application/img/subnav/squiggle2.png" alt="squiggle"/>Back</a>
<a class='next' href='#' onclick='next(<?=$module['id']?>)'>Next <img src="/system/application/img/subnav/squiggle.png" alt="squiggle"/></a>
</div>
<!-- END MODULE NAV -->

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
