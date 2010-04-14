<div id="module">
<div id="<?=$viz['modvizid']?>" style="width:600px;height:300px; display: block; margin: 40px;"></div>
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
      }
   };
   var data = <?php echo $json ?>;  
   $.plot($("#<?=$viz['modvizid'] ?>"), data, options);
});
</script>
</div>



