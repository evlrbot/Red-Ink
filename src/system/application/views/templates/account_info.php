<?= form_open(site_url('me/account_update'),array('id'=>'bigform')); ?>

<h1>Account Info</h1>
<p><?= form_label('E-Mail','email'); ?></p>
<?= form_error('email'); ?>
<?= form_input(array('id'=>'email','name'=>'email','value'=>"$email")); ?>

<p><?= form_label('Reset Password','password1'); ?></p>
<?= form_error('password1'); ?>
 <?= form_password(array('id'=>'password1','name'=>'password1')); ?>

<p><?= form_label('Verify Password','password2'); ?></p>
<?= form_error('password2'); ?>
<?= form_password(array('id'=>'password2','name'=>'password2')); ?>

<p><?= form_label('First Name','fname'); ?></p>
<?= form_error('fname'); ?>
 <?= form_input(array('id'=>'fname','name'=>'fname','value'=>"$fname")); ?>

<p><?= form_label('Last Name','lname'); ?></p>
<?= form_error('lname'); ?>
 <?= form_input(array('id'=>'lname','name'=>'lname','value'=>"$lname")); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Update')); ?></p>

<h1>Expensify Account</h1>
<p><?= form_label('Login','expensify_login'); ?></p>
<?= form_error('expensify_login'); ?>
 <?= form_input(array('id'=>'expensify_login','name'=>'expensify_login','value'=>$expensify_username)); ?>

<p><?= form_label('Password','expensify_password'); ?></p>
<?= form_error('expensify_password'); ?>
<?= form_password(array('id'=>'expensify_password','name'=>'expensify_password','value'=>$expensify_password)); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Update')); ?></p>

<h1>Wesabe Account</h1>
<p><?= form_label('Login','wesabe_login'); ?></p>
<?= form_error('wesabe_login'); ?>
 <?= form_input(array('id'=>'wesabe_login','name'=>'wesabe_login','value'=>$wesabe_username)); ?>

<p><?= form_label('Password','wesabe_password'); ?></p>
<?= form_error('wesabe_password'); ?>
<?= form_password(array('id'=>'wesabe_password','name'=>'wesabe_password','value'=>$wesabe_password)); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Update')); ?></p>

<?= form_close(); ?>