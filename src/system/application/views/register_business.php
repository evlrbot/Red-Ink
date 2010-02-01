<?= form_open(site_url('business/add'),array('id'=>'businessinfoform')); ?>

<h1>Business Info</h1>

<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name','value'=>"",'size'=>'50','style'=>'width:50%')); ?>

<p><?= form_label('Address 1','address1'); ?></p>
<?= form_error('address1'); ?>
<?= form_input(array('id'=>'address1','name'=>'address1','value'=>"",'size'=>'50','style'=>'width:50%')); ?>

<p><?= form_label('Address 2','address2'); ?></p>
<?= form_error('address2'); ?>
<?= form_input(array('id'=>'address2','name'=>'address2','value'=>"",'size'=>'50','style'=>'width:50%')); ?>

<p><?= form_label('City','city'); ?></p>
<?= form_error('city'); ?>
<?= form_input(array('id'=>'city','name'=>'city','value'=>"",'size'=>'50','style'=>'width:50%')); ?>

<p><?= form_label('State','state'); ?></p>
<?= form_error('state'); ?>
<?= form_input(array('id'=>'state','name'=>'state','size'=>'50','style'=>'width:50%')); ?>

<p><?= form_label('Zip Code','zipcode'); ?>
<?= form_error('zipcode'); ?>
<?= form_input(array('id'=>'zipcode','name'=>'zipcode','size'=>'50','style'=>'width:50%')); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Submit')); ?></p>

<?= form_close(); ?>
