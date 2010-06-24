<div id='body'>
<?=form_open('invite/validate', array('id'=>'mailform', 'class'=>'invite'));?>
<?=form_label('<p>Enter the name you want your friends to see:</p>', 'sender');?>
<?=form_error('sender');?>
<?=form_input(array('id'=>'sender', 'name'=>'sender', 'value'=>''));?>
<?=form_label('<p>Please list email addresses separated by an empty space:</p>', 'email');?>
<?=form_error('email');?>
<?=form_input(array('id'=>'email', 'name'=>'email', 'value'=>'','size'=>'75'));?>
<?=form_label('<p>Message Preview:</p>', 'message');?>
<?=form_textarea(array('id'=>'pre_message', 'name'=>'pre_message','readonly'=>'true','rows'=>'3','cols'=>'55','value'=>$mod_info['pre_message']));?>
<?=form_label("<p><em>You may add a personal message below</em></p>",'_filler');?>
<?=form_textarea(array('id'=>'message', 'name'=>'message','value'=>'','rows'=>'7','cols'=>'55'));?>
<?=br();?>
<?=br();?>
<?=form_submit(array('value'=>'Invite', 'id'=>'submit'));?>
<?=form_reset(array('value'=>'Reset', 'id'=>'reset'));?>
<?=form_close();?>
</div> 
