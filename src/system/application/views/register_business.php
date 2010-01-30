<?= form_open(site_url('bussiness/add'),array('id'=>'businessinfoform')); ?>

<h1>Business Info</h1>

<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name','value'=>"")); ?>

<p><?= form_label('Address 1','address1'); ?></p>
<?= form_error('address1'); ?>
<?= form_input(array('id'=>'address1','name'=>'address1','value'=>"")); ?>

<p><?= form_label('Address 2','address2'); ?></p>
<?= form_error('address2'); ?>
<?= form_input(array('id'=>'address2','name'=>'address2','value'=>"")); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Submit')); ?></p>

<?= form_close(); ?>
