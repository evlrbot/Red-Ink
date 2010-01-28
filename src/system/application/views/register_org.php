<html>
<head>
<title>Organization Registration</title>
<style type="text/css" media="all">
@import url("/system/application/css/mainstyle.css");
</style>
<script language="javascript" src="/system/application/js/jquery-1.3.2.min.js"></script>
</head>
<body id="login">
<?= form_open(site_url('registerorg'),array('id'=>'registrationform')); ?>
<p><?= form_label('Organization','organization'); ?></p>
<?= form_error('organization'); ?>
<?= form_input(array('id'=>'organization','name'=>'organization')); ?>

<p><?= form_label('Contact','contact'); ?></p>
<?= form_error('contact'); ?>
<?= form_input(array('id'=>'contact','name'=>'contact')); ?>

<p><?= form_label('First Name','fname'); ?></p>
<?= form_error('fname'); ?>
<?= form_input(array('id'=>'fname','name'=>'fname')); ?>

<p><?= form_label('Last Name','lname'); ?></p>
<?= form_error('lname'); ?>
<?= form_input(array('id'=>'lname','name'=>'lname')); ?>

<p><?= form_label('Phone Number','phone1'); ?></p>
<?= form_error('phone1'); ?>
<?= form_input(array('id'=>'phone1','name'=>'phone1')); ?>

<p><?= form_label('Phone Number','phone2'); ?></p>
<?= form_error('phone2'); ?>
<?= form_input(array('id'=>'phone2','name'=>'phone2')); ?>

<p><?= form_label('Phone Number','phone3'); ?></p>
<?= form_error('phone3'); ?>
<?= form_input(array('id'=>'phone3','name'=>'phone3')); ?>

<p><?= form_label('E-Mail','email'); ?></p>
<?= form_error('email'); ?>
<?= form_input(array('id'=>'email','name'=>'email')); ?>

<p><?= form_label('Address1','address1'); ?></p>
<?= form_error('address1'); ?>
<?= form_input(array('id'=>'address1','name'=>'address1')); ?>

<p><?= form_label('Address2','address2'); ?></p>
<?= form_error('address2'); ?>
<?= form_input(array('id'=>'address2','name'=>'address2')); ?>

<p><?= form_label('City','city'); ?></p>
<?= form_error('city'); ?>
<?= form_input(array('id'=>'city','name'=>'city')); ?>

<p><?= form_label('State','state'); ?></p>
<?= form_error('state'); ?>
<?= form_input(array('id'=>'state','name'=>'state')); ?>

<p><?= form_label('Zip Code','zip'); ?></p>
<?= form_error('zip'); ?>
<?= form_input(array('id'=>'zip','name'=>'zip')); ?>

<br/>
<?= form_submit(array('id'=>'submit','value'=>'Register')); ?>
<?=isset($msg) ? $msg : '';?>
<p>If you already have a login, then you may sign-in <a href="<?=site_url('login');?>">here</a>.</p>
<?= form_close(); ?>
<p id="rendertime">Page rendered in {elapsed_time} seconds.</p>

</body>
</html>
