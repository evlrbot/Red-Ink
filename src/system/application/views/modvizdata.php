<div id="module">

<?php

if(count($dataids) > 1) {

	echo renderChartHTML("/system/application/libraries/$template[multidata]", "", "$xml", "myNext", 700, 300, false, false);
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
			
echo "<table>";
echo "<tr>";

foreach($data_sets as $d) {
	
	echo "<td><input name= '" . $d['dataid'] . "' value='" . $d['dataid'] ."' type='checkbox' ". $d['checked'] . "></td><td>" . $d['name'] . "</td><td>" . $d['query'] . "</td>";
	echo "</tr>";	
}

?>

</table>

<p style="text-align: center"><?= form_submit(array('id'=>'submit','value'=>'Save')); ?><?= form_button(array('name'=>'submit2', 'id'=>'submit2','value'=>'submit2', 'type'=>'submit'), 'Save and Go Back'); ?></p>

<?= form_close(); ?>

<?php

$count = 0;

echo "</tbody></table>";

?>

</table>
