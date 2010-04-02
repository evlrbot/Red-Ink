<div id="module">

<?php

	$xml= $chart_data['xml'];

if(count($dataids) > 1) {

	if($viz['viz_stacked']) {
	
		echo renderChartHTML("/system/application/libraries/$template[stacked]", "", "$xml", "myNext", 700, 300, false, false);
	}
	
	else {
	
		echo renderChartHTML("/system/application/libraries/$template[multidata]", "", "$xml", "myNext", 700, 300, false, false);	
	}
}
else {

	echo renderChartHTML("/system/application/libraries/$template[template]", "", "$xml", "myNext", 700, 300, false, false);
}

?>

</div>

<?php

echo "<table id='list' border='0' cellpadding='10' cellspacing='2'>";
echo "<thead><tr><td>Label</td><td>Query</td></tr></thead><tbody>";

echo form_open(site_url("visualization/edit/$modid/$modvizid"));

echo "<div id='viz_name'><label for='viz_name_field'>Viz Name</label><input name= 'viz_name_field' value='$viz[viz_name]' id='viz_name_field'></div>";

if(count($dataids) > 1) {

	echo "<div id='viz_stacked'><label for='viz_stacked_field'>Stack Viz?</label><input name= 'viz_stacked_field' type='checkbox' $viz[viz_stacked] id='viz_stacked_field' value='checked'></div>";
}
			
echo "<table>";
echo "<tr>";

foreach($data_sets as $d) {
	
	echo "<td><input name= '" . $d['dataid'] . "' value='" . $d['dataid'] ."' type='checkbox' ". $d['checked'] . "></td><td>" . $d['name'] . "</td><td>" . $d['query'] . "</td>";
	echo "</tr>";
}

echo "</table>";

?>

<p style="text-align: center"><?= form_submit(array('id'=>'submit','value'=>'Save')); ?><?= form_button(array('name'=>'submit2', 'id'=>'submit2','value'=>'submit2', 'type'=>'submit'), 'Save and Go Back'); ?></p>

<?= form_close(); ?>

<?php

$count = 0;

echo "</tbody></table>";

?>

</table>
