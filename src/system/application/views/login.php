<html>
<head>
<title>Login</title>
<style type="text/css" media="all">
@import url("/system/application/css/mainstyle.css");
</style>
</head>
<body id="login">
<?=form_open('login/auth',array('id'=>'bigform'));?>
<?=form_label('<p>Username</p>','username');?>
<?= form_error('username'); ?>
<?=form_input(array('id'=>'username','name'=>'username','value'=>''));?>
<?=form_label('<p>Password</p>','password');?>
<?= form_error('password'); ?>
<?=form_password(array('id'=>'password','name'=>'password','value'=>''));?>
<?=br();?>
<?=form_submit(array('value'=>'Login','id'=>'submit'));?>
<?=br();?>
<?=isset($msg) ? $msg : '';?>
<p>If you don't have a login, you may sign-up for one <a href="/registeruser">here</a>.
<?=form_close();?>
<p id="rendertime">Page rendered in {elapsed_time} seconds.</p>
</body>
</html>
