<?php
$xml= "<chart caption='Financial Chart' xAxisName='Month' yAxisName='$' showValues='0' numberPrefix=''>";
date_default_timezone_set('America/New_York');
foreach(array_keys($data) as $index) {
  foreach($data[$index] AS $d) {
    $dt = date_create($d['label']);
    $d['label'] = date_format($dt, "M y");
    $xml.= "<set label='$d[label]' value='$d[value]'/>";
  }  
}
$xml.= "</chart>";
?>
<div id="module">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="700" height="300" id="Column3D" >
<param name="movie" value="./system/application/libraries/Column3D.swf" />
<param name="FlashVars" value="&dataXML=<?=$xml?>"
<param name="quality" value="high" />
<embed src="./system/application/libraries/Column3D.swf" flashVars="&dataXML=<?=$xml?>" quality="high" width="700" height="300" name="Column3D" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</div>
