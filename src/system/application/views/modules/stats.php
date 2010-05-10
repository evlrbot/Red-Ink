<table id="stats" cellpadding='10' cellspacing='0'>
<tr>
<td>
<h1>Module</h1>
<p><b><?=$module['name']?>: </b><em><?=$module['description']?></em></p>
<p>Period: <b><?=$module['period']?> Months</b> </p>
<p>Interval: <b> 
<?php
   switch($module['frequency']) {
   case 'day':
   echo "Daily";
   break;
   case 'week':
   echo 'Weekly';
   break;
   case 'month':
   echo 'Monthly';
   break;
   default:
   }
   ?>
</b></p>
</td>
<td>
<h1>Me & Us</h1>
<p>Members: <b><?=$num_members?></b></p>
<p>Our Total: <b>$<?=$total_spend?></b></p>
<?if(isset($my_spend)) { echo "<p>My Total: <b>$$my_spend</b></p>"; }?>
<p>Avg/Visit: <b>$<?=$avg_spend_per_visit?></b></p>
<p>Avg/Interval: <b>$<?=$avg_spend_per_interval?></b></p>
<p>Avg/User: <b>$<?= ($total_spend && $num_members) ? round(($total_spend/$num_members),2) : 0; ?></b></p>

</td>
<td>
<h1>Members</h1>
<ol>
<?php
foreach($members as $member) {
  $username = explode('@',$member['email']);
  echo "<li>$username[0]</li>\n";
}
?>
</ol>
</td>
</tr>
</table>