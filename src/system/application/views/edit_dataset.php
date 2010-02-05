<?= form_open(site_url("dataset/edit/$modid/$id"),array('id'=>'bigform')); ?>

<h1>Edit Dataset</h1>
<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name','value'=>"$name")); ?>
<p><?= form_label('Query','query'); ?></p>
<?= form_error('query'); ?>
<?= form_textarea(array('id'=>'query','name'=>'query','cols'=>50,'rows'=>10, 'value'=>"$query")); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Save')); ?></p>

<?= form_close(); ?>