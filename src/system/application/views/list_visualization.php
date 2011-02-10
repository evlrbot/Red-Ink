<?php echo "<li>Area Chart - <a href='/visualization/add/$modid/1'>add</a></li>"; ?>
<div id='area' style='height: 300px;'></div>

<?php echo "<li>Bar Chart - <a href='/visualization/add/$modid/2'>add</a></li>"; ?>
<div id='bar' style='height: 300px;'></div>

<?php echo "<li>Line Chart - <a href='/visualization/add/$modid/3'>add</a></li>"; ?>
<div id='line' style='height: 300px;'></div>

<script id="source" language="javascript" type="text/javascript">

$(function () {

   var data = [
        {label: 'foo', data: [[1,300], [2,300], [3,300], [4,300], [5,300]]},
        {label: 'bar', data: [[1,800], [2,600], [3,400], [4,200], [5,0]]},
        {label: 'baz', data: [[1,100], [2,200], [3,300], [4,400], [5,500]]},
    ];
    
   var options_area = {
      series: { lines: { show: true, fill: true, steps: false }, points: { show: true } },
      xaxis: { mode: "time", timeformat: '%b' },
      yaxis: { tickFormatter: function(v,axis) {return '$'+v.toFixed(axis.tickDecimals)} },
      grid: { clickable:true, hoverable:true, autoHighlight:true }
   };
   
   var options_bar = {
      series: { lines: { show: false, fill: true, steps: false }, points: { show: true }, bars: {show: true, barWidth: 0.9, align: 'center'} },
      xaxis: { mode: "time", timeformat: '%b' },
      yaxis: { tickFormatter: function(v,axis) {return '$'+v.toFixed(axis.tickDecimals)} },
      grid: { clickable:true, hoverable:true, autoHighlight:true }
   };
   
   var options_line = {
      series: { lines: { show: true, fill: false, steps: false }, points: { show: true } },
      xaxis: { mode: "time", timeformat: '%b' },
      yaxis: { tickFormatter: function(v,axis) {return '$'+v.toFixed(axis.tickDecimals)} },
      grid: { clickable:true, hoverable:true, autoHighlight:true }
   };   
   
   $.plot($("#area"), data, options_area);
   $.plot($("#bar"), data, options_bar);
   $.plot($("#line"), data, options_line);   

});
   
</script>

