<?php

// this can be made more dynamic later...


$xml_string= "<chart caption='Financial Chart' xAxisName='Month' yAxisName='$' showValues='0' numberPrefix=''>";

$xml_string.= "<dataset seriesName='Deposits'>";

// deposits

foreach($data['Deposits'] as $deposit) {

  $xml_string.= "<set value='" . $deposit['deposits'] . "' />";
}

$xml_string.= "</dataset>";

// spending

$xml_string.= "<dataset seriesName='Spending'>";

foreach($data['Spending'] as $spent) {

  $xml_string.= "<set value='" . $spent['spending'] . "' />";
}

$xml_string.= "</dataset>";

$xml_string.= "</chart>";


// Try just deposits until I can figure out why the multi bar chart wont load the xml


$xml_string2= "<chart caption='Financial Chart' xAxisName='Month' yAxisName='$' showValues='0' numberPrefix=''>";

// deposits

foreach($data['Deposits'] as $desposit) {
  
  $xml_string2.= "<set label='" .$deposit['created']. "' value='" . $desposit['deposits'] . "'/>";
}

$xml_string2.= "</chart>";


?>
<div id="module">

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="700" height="300" id="Column3D" >
<param name="movie" value="./system/application/libraries/Column3D.swf" />
<param name="FlashVars" value="&dataXML=<?php echo $xml_string2 ?>"
<param name="quality" value="high" />
<embed src="./system/application/libraries/Column3D.swf" flashVars="&dataXML=<?php echo $xml_string2 ?>" quality="high" width="700" height="300" name="Column3D" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>

</div>
