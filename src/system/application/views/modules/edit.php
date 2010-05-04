<?= form_open(site_url("campaign/edit/$module[id]"),array('id'=>'bigform')); ?>

<h1>Edit Campaign <a href='<?=site_url().'campaign/index'?>' class='small'>back</a></h1>
<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name','value'=>"$module[name]",'size'=>30)); ?>

<p><?= form_label('Description','description'); ?></p>
<?= form_error('description'); ?>
<?= form_textarea(array('id'=>'description','name'=>'description','cols'=>37,'rows'=>2, 'value'=>"$module[description]")); ?>

<?php
echo form_open(site_url("module/edit/$module[id]"),array('id'=>'bigform'));
$this->module->load($module['id']);
echo "<table id='list' border='0' cellpadding='10' cellspacing='2'><thead><tr><td>Timeframe</td><td>Interval</td><td>Stacked</td></tr></thead>";
echo "<tbody><tr><td><select name='period'>";
$timeframes = array('Year'=>'year', '6 Months'=>'6month', '3 Months'=>'3month');
foreach($timeframes as $key=>$value) {
  $timeframe_select = $timeframe == $value ? "selected" : "";
  echo "<option value='$value' $timeframe_select>$key</option>\n";
}
echo "</select></td>\n";
echo "<td><select name='frequency'>";
$intervals = array('Month'=>'month', 'Week'=>'week', 'Day'=>'day');
foreach($intervals as $key=>$value) {
  $interval_select= $interval== $value ? "selected" : "";
  echo "<option value='$value' $interval_select>$key</option>\n";
}
echo "</select></td>\n";
echo "<td><input type='checkbox' name='stacked' value='checked' $module[stacked]></td>\n";
echo "</tr></tbody></table>\n";

echo "<table id='list' border='0' cellpadding='10' cellspacing='2'>\n";
echo "<thead><tr><td>Active</td><td>Label</td><td>Memos</td><td>Color</td><td>Actions</td></tr></thead><tbody>\n";
$i=0;
foreach($filters as $d) {
  $row_class = $i++ % 2 == 0 ? 'c1' : 'c2';
  $checked = $d['active'] ? 'checked' : '';
  echo "<tr class='$row_class'><td><input type='checkbox' name='$d[filter_id]_active' value='$d[filter_id]'$checked></td><td>" . $d['name'] . "</td>";
  echo "<td><ul>";
  foreach($this->filter->get_memos($d['filter_id']) AS $f) {
    echo "<li>$f[memo]</li>\n";
  }
  echo "</ul></td>";


  $colors = array('Green'=>'#006600',
		  'Red'=>'#CC0000',
		  'Blue'=>'#0033CC',
		  'Yellow'=>'#FFEA00',		  
		  'Purple'=>'#660066',
		  'Orange'=>'#FF9900');

  echo "<td><select name='" . $d['filter_id'] . "_color'>";
  foreach($colors AS $key=>$value) {
    $selected = $d['color'] == $value ? "selected" : "";
    echo "<option value='$value'$selected>$key</option>\n";
  }
  echo "</select></td>\n";
  echo "<td><a href='/filter/edit/$d[filter_id]'>Edit</a> <a href='/campaign/remove_filter/$module[id]/$d[filter_id]'>Remove</a></td></tr>";
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
<?= form_close(); ?>