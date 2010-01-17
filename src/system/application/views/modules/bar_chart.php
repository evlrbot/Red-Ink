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
    $xml.= "<set value='".abs($d['value'])."' color='$colors[$i]'/>";
  }
  $xml.="</dataset>";
  $i++;
}
$xml.= "</chart>";
?>

<div id="module">
<?php
//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
echo renderChartHTML("./system/application/libraries/MSColumn2D.swf", "", $xml, "myNext", 600, 300, false); 
?>
</div>

<div id="module">
<?php
//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
echo renderChartHTML("./system/application/libraries/StackedColumn2D.swf", "", $xml, "myNext", 600, 300, false, false);
?>
</div>

<!-- legacy method, should use PHP method above -->
<div id="module">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/fl\
ash/swflash.cab#version=8,0,0,0" width="700" height="300" id="MSColumn3D.swf" >
<param name="movie" value="./system/application/libraries/MSColumn3D.swf" />
<param name="FlashVars" value="&dataXML=<?=$xml?>"
<param name="quality" value="high" />
<embed src="./system/application/libraries/MSColumn3D.swf" flashVars="&dataXML=<?=$xml?>" quality="high" width="700" height="300" name="Column3D" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</div>
<!-- -->

<div id="module">
<?php
//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
echo renderChartHTML("./system/application/libraries/StackedColumn3D.swf", "", $xml, "myNext", 600, 300, false, false);
?>

</div>



