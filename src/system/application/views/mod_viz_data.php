

<div id="placeholder" style="width:600px;height:300px"></div>

<script id="source" language="javascript" type="text/javascript">

$(function () {
    
  var options = {
	series: {
      lines: { show: true, fill: true },
	  points: { show: true }
	},
	xaxis: {
      mode: "time",  
    }
    
  };

  var data = [
	{ label: "Foo", data: [ [10, 1], [17, 13], [30, 5] ] },
	{ label: "Bar", data: [ [11, 13], [19, 11], [30, 4] ] }
	];
  
  $.plot($("#placeholder"), data, options);
});

</script>


<?php

echo form_open(site_url("visualization/edit/$modid/$modvizid"),array('id'=>'bigform'));
echo "<div id='viz_name'><label for='viz_name_field'>Visualization Label</label><input name='viz_name_field' value='$viz[viz_name]' id='viz_name_field'></div>\n";
if(count($data_ids) > 1) {
  echo "<div id='viz_stacked'><label for='viz_stacked_field'>Stack Viz?</label><input name= 'viz_stacked_field' type='checkbox' $viz[viz_stacked] id='viz_stacked_field' value='checked'></div>\n";
}
echo "<table id='list' border='0' cellpadding='10' cellspacing='2'>\n";
echo "<thead><tr><td>Active</td><td>Label</td><td>Query</td><td>Color</td></tr></thead><tbody>\n";
echo "<tr>";
foreach($data_sets as $d) {	
  echo "<td><input name= '" . $d['dataid'] . "' value='" . $d['dataid'] ."' type='checkbox' ". $d['checked'] . "></td><td>" . $d['name'] . "</td><td>" . $d['query'] . "</td>\n";
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
