<div id="module">
<script type="text/javascript">
  var bgcolor="#FFFFFF";
  var chgcolor="#99FFFF";
  function change(thing){
    thing.style.backgroundColor = chgcolor;
   }
  function changeback(thing) {
    thing.style.backgroundColor = bgcolor;
   }
</script>
<h2>My Transactions</h2>
<table id='tabular'>
<?php 
if (sizeof($transactions)==0) 
   echo "<p style='background-color:darkred;color:white;font-size:20px'>You currently have no transactions.</p>";
else{
echo "<thead><tr><td>Created</td><td>$$$</td><td>Memo</td><td>Merchant</td></tr></thead><tbody>\n";
$i=0;
foreach ($transactions AS $t) {
 $rowstyle = ($i++%2==0) ? "row1" : "row2";
  $t["amount"] = $t["amount"]/100;
  if ($t['userid']==$_SESSION['userid']) {
  $bgcolor1="this.bgColor='darkred'";
  $bgcolor2="this.bgColor='blue'";
  echo "<tr style='background-color:#FFFFFF;' onmouseover='change(this);' onmouseout=changeback(this);'><td>$t[created]</td><td>\$$t[amount]&nbsp;</td><td>$t[memo]&nbsp;</td><td>$t[merchant]</td></tr>\n";
  }
  else
  echo "<tr class='$rowstyle'><td>$t[created]</td><td>\$$t[amount]&nbsp;</td><td>$t[memo]&nbsp;</td><td>$t[merchant]</td></tr>\n";
  }
 }
?>
</tbody></table>
</div>
