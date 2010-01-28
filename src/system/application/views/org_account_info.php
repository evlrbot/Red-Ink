<div id="user_body">
<?= form_open(site_url('organization/account_update'),array('id'=>'orgaccountinfoform')); ?>

<h1>Organization Account Info</h1>
<p><?= form_label('Organization','organization'); ?></p>
<?= form_error('organization'); ?>
<?= form_input(array('id'=>'organization','name'=>'organization','value'=>"$organization")); ?>

<p><?= form_label('Contact','email'); ?></p>
<?= form_error('email'); ?>
<?= form_input(array('id'=>'email','name'=>'email','value'=>"$email")); ?>

<p><?= form_label('First Name','fname'); ?></p>
<?= form_error('fname'); ?>
<?= form_input(array('id'=>'fname','name'=>'fname','value'=>"$fname")); ?>

<p><?= form_label('Last Name','lname'); ?></p>
<?= form_error('lname'); ?>
<?= form_input(array('id'=>'lname','name'=>'lname','value'=>"$lname")); ?>

<p><?= form_label('Phone Number','phone1'); ?></p>
<?= form_error('phone1'); ?>
<?= form_input(array('id'=>'phone1','name'=>'phone1','value'=>"$phone1")); ?>

<p><?= form_label('Phone Number','phone2'); ?></p>
<?= form_error('phone2'); ?>
<?= form_input(array('id'=>'phone2','name'=>'phone2','value'=>"$phone2")); ?>

<p><?= form_label('Phone Number','phone3'); ?></p>
<?= form_error('phone3'); ?>
<?= form_input(array('id'=>'phone3','name'=>'phone3','value'=>"$phone3")); ?>

<p><?= form_label('E-Mail','email'); ?></p>
<?= form_error('email'); ?>
<?= form_input(array('id'=>'email','name'=>'email','value'=>"$email")); ?>

<p><?= form_label('Address1','address1'); ?></p>
<?= form_error('address1'); ?>
<?= form_input(array('id'=>'address1','name'=>'address1','value'=>"$address1")); ?>

<p><?= form_label('Address2','address2'); ?></p>
<?= form_error('address2'); ?>
<?= form_input(array('id'=>'address2','name'=>'address2','value'=>"$address2")); ?>

<p><?= form_label('City','city'); ?></p>
<?= form_error('city'); ?>
<?= form_input(array('id'=>'city','name'=>'city','value'=>"$city")); ?>

<p><?= form_label('State','state'); ?></p>
<?= form_error('state'); ?>
<?= form_input(array('id'=>'state','name'=>'state','value'=>"$state")); ?>

<p><?= form_label('Zip Code','zip'); ?></p>
<?= form_error('zip'); ?>
<?= form_input(array('id'=>'zip','name'=>'zip','value'=>"$zip")); ?>

<p><?= form_label('Reset Password','password1'); ?></p>
<?= form_error('password1'); ?>
<?= form_password(array('id'=>'password1','name'=>'password1')); ?>

<p><?= form_label('Verify Password','password2'); ?></p>
<?= form_error('password2'); ?>
<?= form_password(array('id'=>'password2','name'=>'password2')); ?>

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
</div>