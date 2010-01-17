<?php
$xml= "<chart caption='Financial Chart' xAxisName='Month' yAxisName='$' showValues='0' numberPrefix='$' canvasbgColor='FFFFFF' canvasBorderColor='000000' canvasBorderThickness='2'>";
$colors = array("FF0000","0E2964");
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
  $xml.= "<dataset seriesName='$index'>";
  foreach($data[$index] AS $d) {
    $xml.= "<set value='".abs($d['value']/10.0)."' color='$colors[$i]'/>";
  }
  $xml.="</dataset>";
  $i++;
}
$xml.= "</chart>";
?>


<div id="module">
<?php
echo renderChartHTML("./system/application/libraries/StackedColumn3D.swf", "", $xml, "myNext", 800, 400, false, false);
?>

</div>



