<?= form_open(site_url("business/edit/$biz[id]"),array('id'=>'bigform')); ?>

<h1>Business Info</h1>

<?=isset($msg) ? $msg : '';?>

<p><?= form_label('Name','name'); ?></p>
<?= form_error('name'); ?>
<?= form_input(array('id'=>'name','name'=>'name','value'=>"$biz[name]",'size'=>'30')); ?>

<p><?= form_label('Address 1','address1'); ?></p>
<?= form_error('address1'); ?>
<?= form_input(array('id'=>'address1','name'=>'address1','value'=>"$biz[address1]",'size'=>'30')); ?>

<p><?= form_label('Address 2','address2'); ?></p>
<?= form_error('address2'); ?>
<?= form_input(array('id'=>'address2','name'=>'address2','value'=>"$biz[address2]",'size'=>'30')); ?>

<p><?= form_label('City','city'); ?></p>
<?= form_error('city'); ?>
<?= form_input(array('id'=>'city','name'=>'city','value'=>"$biz[city]",'size'=>'30')); ?>

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
<?= form_dropdown('state',$state_list, $biz['state']); ?>

<p><?= form_label('Zip Code','zipcode'); ?>
<?= form_error('zipcode1'); ?>
<?= form_error('zipcode2'); ?>
<?= form_input(array('id'=>'zipcode1','name'=>'zipcode1','size'=>'5','value'=>"$biz[zip1]")); ?> - 
<?= form_input(array('id'=>'zipcode2','name'=>'zipcode2','size'=>'4','value'=>"$biz[zip2]")); ?>
<?= form_hidden(array('bizid'=>"$biz[id]"));?>
<p><?= form_submit(array('id'=>'submit','value'=>'Update')); ?></p>

<h1>Memo Strings <a href='/memos/add/<?=$biz['id']?>' class='small'>add</a></h1>
<?php if(count($memo)) { ?>
<table cellpadding="3" cellspacing="2" border="0" id="list"><thead><tr><td width='400px'>Memo</td><td width='100px'>Action</td></tr></thead>
<?php
$count=0;
foreach($memo AS $m) {
  $count++;
  $style = $count % 2 ? "c1":"c2";
  echo "<tr class='$style'><td>$m[memo]</td><td align='center'><a href='/memo/remove/$biz[id]/$m[id]'>delete</a></td></tr>";
}
?>
</table>
<?php } ?>
<?= form_close(); ?>
