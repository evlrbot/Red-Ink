<div id="module">
   <table border='1' width='100%'>
<?php 
echo "<tr><td>Create</td><td>Amount</td><td>Memo</td><td>Merchant</td></tr>\n";
foreach ($transactions AS $t) {
  $t["amount"] = $t["amount"]/100;
  echo "<tr><td>$t[created]</td><td>\$$t[amount]&nbsp;</td><td>$t[memo]&nbsp;</td><td>$t[merchant]</td></tr>\n";
}
?>
</table>
</div>