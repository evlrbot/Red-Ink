<table id="stats" cellpadding='10' cellspacing='0'>
<tr>
<td>
<h1>Us</h1>
<p><b>Membership:</b> <?=$num_members?></p>
<p><b>Total:</b> $<?=$total_spend?></p>
<p><b>Average:</b> $<?=round(($total_spend/$num_members),2);?></p>
<p><b>Activity:</b> N/A</p>
</td>
<td>
<h1>Me</h1>
<p><b>Total:</b> $<?=$my_spend?></p>
</td>
<td>
<h1>Members</h1>
<ol>
<?php
foreach($members as $member) {
  echo "<li>$member[email]</li>\n";
}
?>
</ol>
</td>
</tr>
</table>