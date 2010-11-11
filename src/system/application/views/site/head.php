<!--
Red Ink ~ Open Source Consumer Analytics for People and Communities
Copyright (C) 2010  Ryan O'Toole - ROT@MEDIA.MIT.EDU

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->
<html>
<head>
<title><?php echo isset($webpagename) ? $webpagename : "Red Ink ~ Where money talks";?></title>
<link rel="shortcut icon" href="http://www.make-them-think.org/img/redink.ico.png" />
<style type="text/css" media="all">
@import url("/system/application/css/mainstyle.css");
</style>
<script language="javascript" src="http://www.make-them-think.org/lib.js"></script>
<script language="javascript" src="/system/application/js/jquery-1.3.2.min.js" ></script>
<script language="javascript" src="/system/application/js/jquery.flot.js" ></script>
<script language="javascript" src="/system/application/js/jquery.flot.stack.js" ></script>
<script language="javascript" src="/system/application/js/jquery.form.js" ></script>
<script type="text/javascript">
var widgets = new Array(
<?php
$tmp = array();
foreach($data as $d) {
   array_push($tmp,$d['modid']);
}
echo implode(",",$tmp);
?>
);

function prev(id) {
  id = widgets.indexOf(id);
  prev_id = id - 1;
  if(prev_id < 0) {
    prev_id = widgets.length - 1;
  }
  $('#module-'+widgets[id]).hide('fast');
  $('#module-'+widgets[prev_id]).show('fast');
}

function next(id) {
  id = widgets.indexOf(id);
  next_id = id + 1;
  if(next_id == widgets.length ) {
    next_id = 0;
  }
  $('#module-'+widgets[id]).hide('fast');
  $('#module-'+widgets[next_id]).show('fast');
}

$(document).ready(function() {
  // HIDE DIV
<?php
foreach($data as $d) {
   echo "$('#module-$d[modid]').hide();\n";
} 
?>
$('#module-<?=$data[0]['modid']?>').show();
});
</script>
</head>
<body>