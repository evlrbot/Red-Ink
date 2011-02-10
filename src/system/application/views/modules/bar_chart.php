<div id="module">
<div id="<?=$module['id']?>" class="vis"></div>

<script id="source" language="javascript" type="text/javascript">

$(function () {
   var options = {
      series: { <?php if($module['stacked']) { echo "stack: 0,"; } ?>lines: { show: false, fill: true, steps: false }, bars: {show: true, barWidth: .9, align: 'center'}, points: { show: true } },
      xaxis: { mode: "time", timeformat: '%b' },
      yaxis: { tickFormatter: function(v,axis) {return '$'+v.toFixed(axis.tickDecimals)} },
      grid: { clickable:true, hoverable:true, autoHighlight:true }
   };
   var data = <?php echo $json ?>;  
   $.plot($("#<?=$module['id'] ?>"), data, options);

   // BIND INTERACTIVITY FUNCTIONS
   $("#<?=$module['id']?>").bind("plotclick", function (event, pos, item) {
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
</div>



