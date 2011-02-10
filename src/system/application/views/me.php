<div id='user_body'><!-- START USER BODY-->
<h1>Welcome to the Act As One web platform!</h1>

<div id="module">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="700" height="300" id="Column3D" >
<param name="movie" value="./system/application/libraries/Bar2D.swf" />
<param name="FlashVars" value="&dataURL=/system/application/models/Data.xml&chartWidth=700&chartHeight=300">
<param name="quality" value="high" />
<embed src="./system/application/libraries/Bar2D.swf" flashVars="&dataURL=./system/application/models/Data.xml&chartWidth=700&chartHeight=300" quality="high" width="700" height="300" name="Column3D" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</div>

<div id="module">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="900" height="300" id="Column3D" >
<param name="movie" value="/libraries/Column3D.swf" />
<param name="FlashVars" value="&dataURL=Data.xml&chartWidth=900&chartHeight=300">
<param name="quality" value="high" />
<embed src="./system/application/libraries/Column3D.swf" flashVars="&dataURL=./system/application/models/Data.xml&chartWidth=700&chartHeight=300" quality="high" width="700" height="300" name="Column3D" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</div>

<div id="module">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="700" height="300" id="Pie3D" >
<param name="movie" value="./system/application/libraries/Pie3dD.swf" />
<param name="FlashVars" value="&dataURL=/system/application/models/Data.xml&chartWidth=700&chartHeight=300">
<param name="quality" value="high" />
<embed src="./system/application/libraries/Pie3D.swf" flashVars="&dataURL=./system/application/models/Data.xml&chartWidth=700&chartHeight=300" quality="high" width="700" height="300" name="Pie3D" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</div>

<div id="module">
<table id="individual_transactions" cellpadding="5" cellspacing="0" border="1">
<thead><tr><td>Amount</td><td>Merchant</td><td>Memo</td><td>Date</td></thead>
<tbody>
<?php 
setlocale(LC_MONETARY, 'en_US');
foreach($transactions AS $t) {
  $amount = money_format("%i",$t['amount']/100.0);
  echo "<tr><td>\$$amount</td><td>$t[merchant]</td><td>$t[memo]&nbsp;</td><td>$t[inserted]</td></tr>\n";
}
?>
</tbody>
</table>
</div>

</div><!-- END USER BODY -->