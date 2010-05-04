<?= form_open(site_url('filters/add'),array('id'=>'bigform')); ?>

<h1>Filter Info</h1>

<?=isset($msg) ? $msg : '';?>

<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name','value'=>"",'size'=>'30')); ?>

<p><?= form_label('Address 1','address1'); ?></p>
<?= form_error('address1'); ?>
<?= form_input(array('id'=>'address1','name'=>'address1','value'=>"",'size'=>'30')); ?>

<p><?= form_label('Address 2','address2'); ?></p>
<?= form_error('address2'); ?>
<?= form_input(array('id'=>'address2','name'=>'address2','value'=>"",'size'=>'30')); ?>

<p><?= form_label('City','city'); ?></p>
<?= form_error('city'); ?>
<?= form_input(array('id'=>'city','name'=>'city','value'=>"",'size'=>'30')); ?>

<p><?= form_label('State','state'); ?></p>
<?= form_error('state'); ?>
<?php 
$state_list = array('AL'=>"Alabama",
		    'AK'=>"Alaska", 
		    'AZ'=>"Arizona", 
		    'AR'=>"Arkansas", 
		    'CA'=>"California", 
		    'CO'=>"Colorado", 
		    'CT'=>"Connecticut", 
		    'DE'=>"Delaware", 
		    'DC'=>"District Of Columbia", 
		    'FL'=>"Florida", 
		    'GA'=>"Georgia", 
		    'HI'=>"Hawaii", 
		    'ID'=>"Idaho", 
		    'IL'=>"Illinois", 
		    'IN'=>"Indiana", 
		    'IA'=>"Iowa", 
		    'KS'=>"Kansas", 
		    'KY'=>"Kentucky", 
		    'LA'=>"Louisiana", 
		    'ME'=>"Maine", 
		    'MD'=>"Maryland", 
		    'MA'=>"Massachusetts", 
		    'MI'=>"Michigan", 
		    'MN'=>"Minnesota", 
		    'MS'=>"Mississippi", 
		    'MO'=>"Missouri", 
		    'MT'=>"Montana",
		    'NE'=>"Nebraska",
		    'NV'=>"Nevada",
		    'NH'=>"New Hampshire",
		    'NJ'=>"New Jersey",
		    'NM'=>"New Mexico",
		    'NY'=>"New York",
		    'NC'=>"North Carolina",
		    'ND'=>"North Dakota",
		    'OH'=>"Ohio", 
		    'OK'=>"Oklahoma", 
		    'OR'=>"Oregon", 
		    'PA'=>"Pennsylvania", 
		    'RI'=>"Rhode Island", 
		    'SC'=>"South Carolina", 
		    'SD'=>"South Dakota",
		    'TN'=>"Tennessee", 
		    'TX'=>"Texas", 
		    'UT'=>"Utah", 
		    'VT'=>"Vermont", 
		    'VA'=>"Virginia", 
		    'WA'=>"Washington", 
		    'WV'=>"West Virginia", 
		    'WI'=>"Wisconsin", 
		    'WY'=>"Wyoming"
		    );
?>
<?= form_dropdown('state',$state_list,"MA"); ?>

<p><?= form_label('Zip Code','zipcode'); ?>
<?= form_error('zipcode1'); ?>
<?= form_error('zipcode2'); ?>
<?= form_input(array('id'=>'zipcode1','name'=>'zipcode1','size'=>'5')); ?> - 
<?= form_input(array('id'=>'zipcode2','name'=>'zipcode2','size'=>'4')); ?>

<p><?= form_submit(array('id'=>'submit','value'=>'Submit')); ?></p>

<?= form_close(); ?>
