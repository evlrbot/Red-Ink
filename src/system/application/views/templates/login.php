<div id="body">
<?=form_open('login',array('id'=>'bigform','class'=>'login','method'=>'post'));?>
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
<p>If you don't have a login, you may sign-up for one <a href="/SignUp">here</a>.
<?=form_close();?>
</div>

</div>
