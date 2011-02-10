<title>Red Ink Invite</title>
<div id='body'>
<?=form_open('invite/validate', array('id'=>'mailform', 'class'=>'invite', 'method'=>'post'));?>
<?=form_label('<p>* Your name:</p>', 'sender');?>
<?=form_error('sender');?>
<?=form_input(array('id'=>'sender', 'name'=>'sender', 'value'=>''));?>
<?=form_label('<p>Enter e-mail addresses to invite, separated by spaces:</p>', 'email');?>
<?=form_error('email');?>
<?=form_input(array('id'=>'email', 'name'=>'email', 'value'=>'','size'=>'75'));?>
<?=form_label('<p>Invite Message:</p>', 'message');?>
<p>{Insert Your Name Here} has invited you to join the Red Ink Campain:</p><p><b><?=$module['name']?> ~ <?=$module['description']?></b></p>
<?=form_label("<p>Add a personal message:</p>",'_filler');?>
<?=form_textarea(array('id'=>'message', 'name'=>'message','value'=>'','rows'=>'7','cols'=>'55'));?>
<?=form_hidden(array('module_id'=>"$module[id]"));?>
<?=br();?>
<?=br();?>
<?=form_submit(array('value'=>'Invite', 'id'=>'submit'));?>
<?=form_reset(array('value'=>'Reset', 'id'=>'reset'));?>
<?=form_close();?>
</div> 
