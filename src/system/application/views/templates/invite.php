<div id="body">
<?=form_open('invite/validate', array('id'=>'mailform', 'class'=>'invite'));?>
<?=form_label('<p>Send To: </p>', 'receiver');?>
<?=form_error('receiever');?>
<?=form_input(array('id'=>'receiver', 'name'=>'receiver', 'value'=>''));?>
<?=form_label('<p>Email:</p>', 'email');?>
<?=form_input(array('id'=>'email', 'name'=>'email', 'value'=>''));?>
<?=form_error('email');?>
<?=form_label('<p>Message</p>', 'message');?>
<?=form_textarea(array('id'=>'message', 'name'=>'message','value'=>''));?>
<?=br();?>
<?=br();?>
<?=form_submit(array('value'=>'Invite', 'id'=>'submit'));?>
<?=form_reset(array('value'=>'Reset', 'id'=>'reset'));?>
<?=br();?>
<?=form_close();?>
</div> 
