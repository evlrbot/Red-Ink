<div id="module">
<h3><?=$viz['viz_name']?></h3>
<div id="<?=$viz['modvizid']?>" class="vis">
</div>
<script id="source" language="javascript" type="text/javascript">
$(function () {
   var options = {
      series: {
         lines: { show: true, fill: true },
	 points: { show: true }
      },
      xaxis: {
         mode: "time",
	 timeformat: '%b'
      },
      yaxis: {
         tickFormatter: function(v,axis) {return '$'+v.toFixed(axis.tickDecimals)}
      }
   };
   var data = <?php echo $json ?>;  
   $.plot($("#<?=$viz['modvizid'] ?>"), data, options);
});
</script>
</div>



