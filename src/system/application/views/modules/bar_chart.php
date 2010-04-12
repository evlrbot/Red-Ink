<?php /*

$xml= "<chart caption='".htmlentities($mod['name'])."' xAxisName='Month' yAxisName='$' showValues='0' numberPrefix='$' canvasbgColor='FFFFFF' canvasBorderColor='000000' canvasBorderThickness='2'>";
$colors = array("FF0000","AA0000","0000FF","0E2964");
date_default_timezone_set('America/New_York');
$keys = array_keys($data);
$xml.= "<categories>";
foreach($data[$keys[0]] AS $d) {
  $d['label'] = date_format(date_create($d['label']), "M y");
  $xml.= "<category label='$d[label]'/>";
}
$xml.="</categories>";

$i = 0;

foreach($keys AS $index) {
  $xml.= "<dataset seriesName='$index' color='$colors[$i]'>";
  foreach($data[$index] AS $d) {
    $xml.= "<set value='".abs($d['value'])."'/>";
  }
  $xml.="</dataset>";
  $i++;
}
$xml.= "</chart>"; */
?> 


<div id="module">

<?php
/*

if(count($viz_data) > 1) {

	if($viz['viz_stacked']) {
	
		echo renderChartHTML("/system/application/libraries/$viz[stacked]", "", "$xml", "myNext", 700, 300, false, false);
	}
	else {
	
		echo renderChartHTML("/system/application/libraries/$viz[multidata]", "", "$xml", "myNext", 700, 300, false, false);	
	}
}
else {

	echo renderChartHTML("/system/application/libraries/$viz[template]", "", "$xml", "myNext", 700, 300, false, false);
}
*/

?>

<div id="<?php echo $chart_name ?>" style="width:600px;height:300px; display: block; margin: 40px;"></div>

<script id="source" language="javascript" type="text/javascript">

$(function () {
  
  //var data= jQuery.parseJSON( json )
  
  
  var options = {
	series: {
      lines: { show: true, fill: true },
	  points: { show: true }
	},
	xaxis: {
      //mode: "time",  
    }
    
  };

  <?php echo $json ?>

  
  $.plot($("#<?php echo $chart_name ?>"), data, options);
});

</script>

</div>



