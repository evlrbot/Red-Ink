<div id="body">
<?=form_open('login/auth',array('id'=>'bigform','class'=>'login'));?>
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
<p>If you don't have a login, you may sign-up for one <a href="/registerusercheck">here</a>.
<?=form_close();?>

<div id='secured'>
<h1>Secured by:</h1>
<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=nZ6MWfESQf31oQXrm38WlnZIYIhdpQKDS8pcZgY8EPjz8tlTEVrNWs"></script></span>
</div>

</div>