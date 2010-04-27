<h1>Edit Visualization <a href='<?=site_url()."campaign/edit/$modid"?>' class='small'>back</a></h1>
<?php
echo form_open(site_url("visualization/edit/$modid/$modvizid"),array('id'=>'bigform'));
echo "<input name='viz_name_field' value='$viz[viz_name]' id='viz_name_field' size='30'>\n";
echo "<style>h3#visname { visibility:hidden; position:absolute; }</style>\n";

include('modules/bar_chart.php');

echo "<table id='list' border='0' cellpadding='10' cellspacing='2'><thead><tr><td>Timeframe</td><td>Interval</td><td>Stacked</td></tr></thead>";
echo "<tbody><tr><td><select name='timeframe'>";
$timeframes= array('Year'=>'year', '6 Months'=>'6month', '3 Months'=>'3month');
foreach($timeframes as $key=>$value) {
  $timeframe_select= $timeframe== $value ? "selected" : "";
  echo "<option value='$value' $timeframe_select>$key</option>\n";
}
echo "</select></td>\n";

echo "<td><select name='interval'>";
$intervals= array('Month'=>'month', 'Week'=>'week', 'Day'=>'day');
foreach($intervals as $key=>$value) {
  $interval_select= $interval== $value ? "selected" : "";
  echo "<option value='$value' $interval_select>$key</option>\n";
}
echo "</select></td>\n";
echo "<td><input type='checkbox' name='viz_stacked_fied' valued='checked'></td>\n";
echo "</tr></tbody></table>\n";

echo "<table id='list' border='0' cellpadding='10' cellspacing='2'>\n";
echo "<thead><tr><td>Active</td><td>Label</td><td>Color</td></tr></thead><tbody>\n";
echo "<tr>";
foreach($data_sets as $d) {
  echo "<td><input name= '" . $d['dataid'] . "' value='" . $d['dataid'] ."' type='checkbox' ". $d['checked'] . "></td><td>" . $d['name'] . "</td>";

  $colors = array('Random'=>'random',
		  'Red'=>'#CC0000',
		  'Blue'=>'#0033CC',
		  'Yellow'=>'#FFEA00',
		  'Green'=>'#006600',
		  'Purple'=>'#660066',
		  'Orange'=>'#FF9900');

  echo "<td><select name='" . $d['dataid'] . "_color'>";
  foreach($colors AS $key=>$value) {
    $selected = $d['color'] == $value ? "selected" : "";
    echo "<option value='$value'$selected>$key</option>\n";
  }
  echo "</select></td>\n";
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

<script id="source" language="javascript" type="text/javascript">

var ajax_options = { 
	success: showResponse,  // post-submit callback 
	url: <?php echo "'" .site_url("visualization/json/$modid/$modvizid"). "'," ?>         // override for form's 'action' attribute 
	//dataType: 'json'        // 'xml', 'script', or 'json' (expected server response type)
}; 

$('input:checkbox').click(function() {
	$('#bigform').ajaxSubmit(ajax_options); 
});

function showResponse(responseText) {

  var options = {
     series: {
       lines: { show: true, fill: true },
       points: { show: true }
     },
     xaxis: {
       mode: 'time',
       timeformat: "%b"
     }
  };
  
//  alert(responseText);
  
  var data= [];
  data.push(responseText);
  alert(data);
  $.plot($("#placeholder"), data, options);
}

</script>