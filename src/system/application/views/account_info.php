<div id="user_body">
<h1>Account Info</h1>
<?= form_open(site_url('me/accountinfo'),array('id'=>'accountinfoform')); ?>
<p><?= form_label('E-Mail','email'); ?></p>
<?= form_error('email'); ?>
<?= form_input(array('id'=>'email','name'=>'email')); ?>

<p><?= form_label('Password','password1'); ?></p>
<?= form_error('password1'); ?>
<?= form_password(array('id'=>'password1','name'=>'password1')); ?>

<p><?= form_label('Verify Password','password2'); ?></p>
<?= form_error('password2'); ?>
<?= form_password(array('id'=>'password2','name'=>'password2')); ?>
<br/>
<?= form_submit(array('id'=>'submit','value'=>'Submit')); ?>
<?= form_close(); ?>
</div>