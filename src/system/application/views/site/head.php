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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title><?php echo isset($webpagename) ? $webpagename : "Red Ink ~ Where money talks";?></title>
<meta name="description" content="Red Ink" />
<link rel="shortcut icon" href="http://www.make-them-think.org/img/redink.ico.png" />
<link rel="stylesheet" type="text/css" href="/system/application/css/mainstyle.css" />
<script type="text/javascript" src="http://www.make-them-think.org/lib.js"></script>
<script type="text/javascript" src="/system/application/js/jquery-1.3.2.min.js" ></script>
<script type="text/javascript" src="/system/application/js/jquery.flot.js" ></script>
<script type="text/javascript" src="/system/application/js/jquery.flot.stack.js" ></script>
<script type="text/javascript" src="/system/application/js/jquery.form.js" ></script>
<script type="text/javascript" src="/system/application/js/jquery.roundabout.min.js" ></script>
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

var current_module = 0;

function goto(id) {
  index = widgets.indexOf(id);
  $('#module-'+current_module).hide();
  $('#module-'+id).show();
  current_module = id;
}

function prev(id) {
  index = widgets.indexOf(id);
  prev_id = index - 1;
  if(prev_id < 0) {
    prev_id = widgets.length - 1;
  }
  $('#module-'+current_module).hide();
  $('#module-'+widgets[prev_id]).show();
  current_module = widgets[prev_id];
}

function next(id) {
  index = widgets.indexOf(id);
  next_id = index + 1;
  if(next_id == widgets.length ) {
    next_id = 0;
  }
  $('#module-'+current_module).hide();
  $('#module-'+widgets[next_id]).show();
  current_module = widgets[next_id];
}

$(document).ready(function() {
      $('ul#user_modules_carousel').roundabout({
				 childSelector: 'li',
         shape: 'lazySusan',
				 reflect: true
      });
   });


$(window).load(function() {
// HIDE WIDGETS
<?php
foreach($data as $d) {
   echo "$('#module-$d[modid]').hide();\n";
} 
?>
$('#module-<?=$data[0]['modid']?>').show();
current_module = widgets[0];
});
</script>
</head>
<body>