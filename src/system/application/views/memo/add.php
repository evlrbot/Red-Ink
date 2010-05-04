<?= form_open(site_url("/memos/add/$filter_id"),array('id'=>'bigform')); ?>

<h1>Add Memo String</h1>
<p><?= form_label('Memo','Memo'); ?></p>
<?= form_error('memo'); ?>
<?= form_input(array('id'=>'memo','name'=>'memo')); ?>
<p><?= form_submit(array('id'=>'submit','value'=>'Add')); ?></p>
<?= form_close(); ?>