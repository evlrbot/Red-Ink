<?= form_open(site_url("campaign/edit/$id"),array('id'=>'bigform')); ?>

<h1>Edit Campaign</h1>
<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name','value'=>"$name")); ?>

<p><?= form_label('Description','description'); ?></p>
<?= form_error('description'); ?>
<?= form_textarea(array('id'=>'description','name'=>'description','cols'=>50,'rows'=>10, 'value'=>"$description")); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Save')); ?></p>

<h1>Data Sets <a href='/dataset/create/<?=$id?>' class='small'>add</a></h1>

<?php 
echo "<table id='list' border='0' cellpadding='10' cellspacing='2'>";
echo "<thead><tr><td>Label</td><td>Query</td><td width='130px'>Actions</td></tr></thead><tbody>";
$count = 0;
foreach($data AS $d) {
  $rowclass = $count % 2 == 0 ? "c1" : "c2";
  $count++;
  echo "<tr class='$rowclass'><td>$d[name]</td><td>$d[query]</td><td><a href='/dataset/edit/$id/$d[dataid]'>edit</a> <a href='/dataset/remove/$id/$d[dataid]'>remove</a></td></tr>";
}
echo "</tbody></table>";
?>
<p><?= form_submit(array('id'=>'submit','value'=>'Save')); ?></p>

<h1>Visualizations <a href='/visualization/add/<?= $id ?>' class='small'>add</a></h1>
<table id='list' border='0' cellpadding='10' cellspacing='2'>
<thead><tr><td width="300px">Name</td><td width="300px">Data Sets</td><td>Actions</td></tr></thead>
<?php
$count=0;
foreach($viz AS $v) {

	$mvid=$v['modvizid'];

	$style = $count++ % 2 ? "c1":"c2";
	echo "<tr class='$style'><td>$v[name]</td>";
	echo "<td>";
  
	if(isset($dataids[$mvid])) {
	
		$string= '';
	
	  foreach($dataids[$mvid] as $dids) {
	  
		  $string.= $dids['name'] . ", ";	  
	  }
	  
	  echo substr($string, 0, -2);
	}
  
  echo "</td>";
  
  
  
  echo "<td><a href='/visualization/edit/$id/$v[modvizid]'>edit</a><a href='/visualization/remove/$id/$v[modvizid]'>remove</a></td></tr>\n";
}
?>
</table>
<?= form_close(); ?>