<?= form_open(site_url("/dataset/create/$modid"),array('id'=>'bigform')); ?>

<h1>Create Dataset</h1>
<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name')); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Save')); ?></p>

<?= form_close(); ?>