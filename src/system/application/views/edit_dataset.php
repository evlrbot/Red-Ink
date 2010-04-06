<?= form_open(site_url("dataset/edit/$modid/$id"),array('id'=>'bigform')); ?>

<h1>Edit Dataset</h1>
<h2>Filter for transactions by associating businesses and other transactions.</h2>

<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name','value'=>"$name")); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Save')); ?></p>

<h1>Filters <a href='<?=site_url()."dataset/addfilter/$id/0/$modid"?>' class='small'>add</a></h1>
<?php print_r($filters); ?>
<?= form_close(); ?>