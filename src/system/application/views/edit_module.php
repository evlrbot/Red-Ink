<?= form_open(site_url("campaign/edit/$id"),array('id'=>'accountinfoform')); ?>

<h1>Edit Campaign </h1>
<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name','value'=>"$name")); ?>

<p><?= form_label('Description','description'); ?></p>
<?= form_error('description'); ?>
<?= form_textarea(array('id'=>'description','name'=>'description','cols'=>50,'rows'=>10, 'value'=>"$description")); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Save')); ?></p>

<h1>Data Sets</h1>

<?php 
foreach($data AS $d) {
  echo "<div id='dataset'>";
  echo "<p>".form_label('Label',"$d[dataid]_label")."</p>";
  echo form_error("$d[dataid]_label");
  echo form_input(array('id'=>"$d[dataid]_label",'name'=>"$d[dataid]_label",'value'=>"$d[name]"));
  echo "<p>".form_label('Query',"$d[dataid]_query")."</p>";
  echo form_error("$d[dataid]_query");
  echo form_textarea(array('id'=>"$d[dataid]_query",'name'=>"$d[dataid]_query",'value'=>"$d[query]",'cols'=>50,'rows'=>10));
  echo "</div>";
}
?>
<p><?= form_submit(array('id'=>'submit','value'=>'Save')); ?></p>
<?= form_close(); ?>