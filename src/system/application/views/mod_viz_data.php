

<div id="placeholder" style="width:700px;height:300px; margin-bottom: 40px;"></div>

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

  
  $.plot($("#placeholder"), data, options);
});

</script>

<?php

echo form_open(site_url("visualization/edit/$modid/$modvizid"),array('id'=>'bigform'));
echo "<div id='viz_name'><label for='viz_name_field'>Visualization Label</label><input name='viz_name_field' value='$viz[viz_name]' id='viz_name_field'></div>\n";

echo "<table id='list' border='0' cellpadding='10' cellspacing='2'><thead><tr><td>Timeframe</td><td>Interval</td></tr></thead>";

echo "<tbody><tr><td><select name='timeframe'><option value='year'>Year</option><option value='6month'>6 Months</option><option value='3month'>3 Months</option></select></td>\n";
echo "<td><select name='interval'><option value='month'>Month</option><option value='week'>Week</option><option value='day'>Day</option></select></td></tr></tbody></table>\n";

echo "<table id='list' border='0' cellpadding='10' cellspacing='2'>\n";
echo "<thead><tr><td>Active</td><td>Label</td><td>Color</td></tr></thead><tbody>\n";
echo "<tr>";
foreach($data_sets as $d) {	
  echo "<td><input name= '" . $d['dataid'] . "' value='" . $d['dataid'] ."' type='checkbox' ". $d['checked'] . "></td><td>" . $d['name'] . "</td>";
  echo "<td><select name='" . $d['dataid'] . "_color'><option value='random'>Random</option><option value='0000FF'>Blue</option><option value='FF0000'>Red</option><option value='F7FF00'>Yellow</option><option value='00FF00'>Green</option><option value='FF00DD'>Purple</option><option value='FF8F00'>Orange</option></select></td>\n";
  echo "</tr>\n";
}
?>
<tfoot><tr><td colspan='4'>
<?=form_submit(array('id'=>'submit','value'=>'Save')); ?>
<?=form_submit(array('id'=>'submit2','value'=>'Save And Return','name'=>'submit2')); ?>
</td></tr></tfoot>

<?php
echo "</tbody></table>";
echo form_close();
?>
</table>
