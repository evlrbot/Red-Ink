<?= form_open(site_url("dataset/edit/$modid/$id"),array('id'=>'bigform')); ?>

<h1>Edit Dataset <a href='<?=site_url()."campaign/edit/$modid"?>' class='small'>back</a></h1>

<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name','value'=>"$name")); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Save')); ?></p>

<h1>Filters <a href='<?=site_url()."dataset/addfilter/$id/0/$modid"?>' class='small'>add</a></h1>
<ul id="bizlist">
<?php 
foreach($filters AS $f) {
   echo "<li><em>$f[name]</em><br/>$f[address1]<br/>";
   echo empty($f['address2']) ? "":"$f[address2]<br/>";
   echo "$f[city], $f[state] $f[zip1]";
   echo !empty($f['zip2']) ? "-$f[zip2]<br/>" : '<br/>';
   echo "<a href='".site_url()."dataset/removefilter/$modid/$id/$f[id]'>remove</a>";
   echo "</li>";
}
?>
</ul>
<?= form_close(); ?>