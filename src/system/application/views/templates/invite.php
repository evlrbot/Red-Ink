<div id="body">
<?=form_open('invite/validate', array('id'=>'mailform', 'class'=>'invite'));?>
<?=form_label('<p>Enter the name you want your friends to see:</p>', 'sender');?>
<?=form_error('sender');?>
<?=form_input(array('id'=>'sender', 'name'=>'sender', 'value'=>''));?>
<?=form_label('<p>Please list email addresses separate by commas below:</p>', 'email');?>
<?=form_input(array('id'=>'email', 'name'=>'email', 'value'=>'','size'=>'150'));?>
<?=form_error('email');?>
<?=form_label('<p>Message:</p>', 'message');?>
<?=form_textarea(array('id'=>'message', 'name'=>'message','value'=>''));?>
<?=br();?>
<?=br();?>
<?=form_submit(array('value'=>'Invite', 'id'=>'submit'));?>
<?=form_reset(array('value'=>'Reset', 'id'=>'reset'));?>
<?=br();?>
<?=form_close();?>
</div> 
