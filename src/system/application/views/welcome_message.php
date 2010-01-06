<html>
<head>
<title>Login</title>
<style type="text/css" media="all">
@import url("/mainstyle.css");
</style>
<script language="javascript" src="/jquery-1.3.2.min.js" ></script>
<script type="text/javascript" src="/jshash-2.2/md5-min.js"></script>
<script language="javascript">
$(document).ready(function() {
   $("#loginform").submit( function(){
     $(password).val(hex_md5($(password).val()));
     
     //$.post("login/auth",{'username':$(username).val(),'password':hash},function(data){alert('success');},'json');
   });
});
</script>
</head>
<body>
<?=form_open('login/auth',array('id'=>'loginform'));?>
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
<p>If you don't have a login, you may sign-up for one <a href="/RegisterUser">here</a>.
<?=form_close();?>
<p id="rendertime">Page rendered in {elapsed_time} seconds.</p>
</body>
</html>
