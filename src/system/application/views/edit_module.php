<?= form_open(site_url("campaign/edit/$id"),array('id'=>'bigform')); ?>

<h1>Edit Campaign <a href='<?=site_url().'campaign/index'?>' class='small'>back</a></h1>
<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name','value'=>"$name",'size'=>30)); ?>

<p><?= form_label('Description','description'); ?></p>
<?= form_error('description'); ?>
<?= form_textarea(array('id'=>'description','name'=>'description','cols'=>40,'rows'=>5, 'value'=>"$description")); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Save')); ?></p>

<h1>Data Sets <a href='/dataset/create/<?=$id?>' class='small'>add</a></h1>

<?php 
echo "<table id='list' border='0' cellpadding='10' cellspacing='2'>";
echo "<thead><tr><td>Label</td><td>Filters</td><td width='130px'>Actions</td></tr></thead><tbody>";
$count = 0;
foreach($data AS $d) {
  $rowclass = $count % 2 == 0 ? "c1" : "c2";
  $count++;
  echo "<tr class='$rowclass'><td>$d[name]</td>";
  echo "<td><ul>";
  foreach($this->data->get_filters($d['dataid']) AS $f) {
    echo "<li><a href='".site_url()."business/edit/$f[id]' target='_blank'>$f[name]</a></li>";
  }
  echo "</ul></td>";
  echo "<td><a href='/dataset/edit/$id/$d[dataid]'>edit</a> <a href='/dataset/remove/$id/$d[dataid]'>remove</a></td></tr>";
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