<html>
<head>
<title>User Registration</title>
<style type="text/css" media="all">
@import url("/system/application/css/mainstyle.css");
</style>
<script language="javascript" src="/system/application/js/jquery-1.3.2.min.js"></script>
</head>
<body id="login">
<?= form_open(site_url('registeruser'),array('id'=>'bigform')); ?>
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
<?= form_submit(array('id'=>'submit','value'=>'Register')); ?>
<?=isset($msg) ? $msg : '';?>
<p>If you already have a login, then you may sign-in <a href="<?=site_url('login');?>">here</a>.</p>
<?= form_close(); ?>
<p id="rendertime">Page rendered in {elapsed_time} seconds.</p>

</body>
</html>
