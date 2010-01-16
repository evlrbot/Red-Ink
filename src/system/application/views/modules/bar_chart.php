<?php
$xml= "<chart caption='Financial Chart' xAxisName='Month' yAxisName='$' showValues='0' numberPrefix='' paletteColors='FF0000,0000FF'>";
$colors = array("FF0000","00AA00");
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
    $xml.= "<set value='$d[value]' color='$colors[$i]'/>";
  }
  $xml.="</dataset>";
  $i++;
}
//$xml.="<trendlines><line startValue='26000' color='91C728' displayValue='Target' showOnTop='1'/></trendlines><styles><definition><style name='CanvasAnim' type='animation' param='_xScale' start='0' duration='1' /></definition><application><apply toObject='Canvas' styles='CanvasAnim' /></application></styles>";
$xml.= "</chart>";
echo "<pre>$xml</pre>"
?>
<div id="module">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="700" height="300" id="MSColumn3D.swf" >
<param name="movie" value="./system/application/libraries/MSColumn3D.swf" />
<param name="FlashVars" value="&dataXML=<?=$xml?>"
<param name="quality" value="high" />
<embed src="./system/application/libraries/MSColumn3D.swf" flashVars="&dataXML=<?=$xml?>" quality="high" width="700" height="300" name="Column3D" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</div>
