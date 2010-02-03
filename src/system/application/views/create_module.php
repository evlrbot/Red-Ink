<?= form_open(site_url('campaign/create'),array('id'=>'bigform')); ?>

<h1>Create A New Campaign </h1>
<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name','value'=>"")); ?>

<p><?= form_label('Description','description'); ?></p>
<?= form_error('description'); ?>
<?= form_textarea(array('id'=>'description','name'=>'description','cols'=>50,'rows'=>10)); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Create')); ?></p>

<?= form_close(); ?>