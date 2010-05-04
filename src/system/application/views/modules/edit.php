<?= form_open(site_url("campaign/edit/$id"),array('id'=>'bigform')); ?>

<h1>Edit Campaign <a href='<?=site_url().'campaign/index'?>' class='small'>back</a></h1>
<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name','value'=>"$name",'size'=>30)); ?>

<p><?= form_label('Description','description'); ?></p>
<?= form_error('description'); ?>
<?= form_textarea(array('id'=>'description','name'=>'description','cols'=>40,'rows'=>5, 'value'=>"$description")); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Save')); ?></p>

<!--- START INSERT -->
<?php
echo form_open(site_url("module/edit/$id"),array('id'=>'bigform'));
$this->module->load($id);

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
echo "<td><input type='checkbox' name='viz_stacked_field' value='checked'" . $viz['viz_stacked'] . "></td>\n";
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
<!-- STOP INSERT -->

<h1>Filters <a href='/campaign/add_filter/<?=$id?>' class='small'>add</a></h1>

<?php 
echo "<table id='list' border='0' cellpadding='10' cellspacing='2'>";
echo "<thead><tr><td>Filter</td><td>Memos</td><td width='130px'>Actions</td></tr></thead><tbody>";
$count = 0;
foreach($filters AS $d) {
  $rowclass = $count % 2 == 0 ? "c1" : "c2";
  $count++;
  echo "<tr class='$rowclass'><td>$d[name]</td>";
  echo "<td><ul>";
  foreach($this->filter->get_memos($d['filter_id']) AS $f) {
    echo "<li>$f[memo]</li>\n";
  }
  echo "</ul></td>";
  echo "<td><a href='/filter/edit/$d[filter_id]'>edit</a> <a href='/campaign/remove_filter/$id/$d[filter_id]'>Remove</a></td></tr>";
}
echo "</tbody></table>";
?>
<p><?= form_submit(array('id'=>'submit','value'=>'Save')); ?></p>

<h1>Visualizations <a href='/visualization/add/<?= $id ?>' class='small'>add</a></h1>
<table id='list' border='0' cellpadding='10' cellspacing='2'>
<thead><tr><td width="300px">Viz Name</td><td width="300px">Chart Type</td><td width="300px">Data Sets</td><td>Actions</td></tr></thead>
<?php
$count = 0;
foreach($viz AS $v) {
  $style = $count++ % 2 ? "c1":"c2";	
  echo "<tr class='$style'><td>$v[viz_name]</td>";	
  echo "<td>$v[name]</td>";	
  // load the dataids for each viz
  echo "<td><ul>";  
  foreach($modvizdata[$v['modvizid']] as $mvd) {
    //echo "<li>$mvd[name]</li>\n";
    echo "<li><a href='".site_url()."dataset/edit/$id/$mvd[moddataid]'>$mvd[name]</a></li>";
  }
  echo "</ul></td>";
  echo "<td><a href='/visualization/edit/$id/$v[modvizid]'>edit</a> <a href='/visualization/remove/$id/$v[modvizid]'>remove</a></td></tr>\n";
}
?>
</table>
<p><?= form_submit(array('id'=>'submit','value'=>'Save')); ?></p>
<?= form_close(); ?>