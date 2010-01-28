<?= form_open(site_url("campaign/edit/$id"),array('id'=>'registrationform')); ?>

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
echo "<table id='dataset' border='0' cellpadding='10' cellspacing='2'>";
echo "<thead><tr><td>Label</td><td>Query</td><td width='100px'>Actions</td></tr></thead><tbody>";
$count = 0;
foreach($data AS $d) {
  $rowclass = $count % 2 == 0 ? "c1" : "c2";
  $count++;
  echo "<tr class='$rowclass'><td>$d[name]</td><td>$d[query]</td><td><a href='/dataset/edit/$d[dataid]'>edit</a> &nbsp;&nbsp;<a href='/dataset/remove/$id/$d[dataid]'>remove</a></td></tr>";
}
echo "</tbody></table>";
?>
<p><?= form_submit(array('id'=>'submit','value'=>'Save')); ?></p>

<h1>Visualizations</h1>
<?php 
echo "<table id='dataset' cellpadding='10' cellspacing='2' border='0'";
echo "<tr><td>Name</td><td>Template</td><td>multi-data (t/f)</td></tr>";
$count=0;
foreach($vis AS $v) {
  $rowclass = $count % 2 == 0 ? "c1" : "c2";
  $count++;
  echo "<tr class='$rowclass'><td>$v[name]</td><td>$v[template]</td><td>$v[multidata]</td></tr>";
}
echo "</table>";
?>


<?= form_close(); ?>