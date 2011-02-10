<div id="module">
<script type="text/javascript">
  function getJsonData() {
    if (window.XMLHttpRequest())
     //code for all browsers except IE5,6
   { data_request = new XMLHttpRequest(); }
   
   else 
    // code for IE5,6
  {  data_request = new ActiveXObject("Microsoft.XMLHTTP"); }

  data_request.onreadystatechange=function()
   {
    if (data_request.readyState==4 && data_request.status==200)
      {
       document.getElementByld("myDiv").innerHTML=data_request.responseText;
      }
   }
   data_request.open("GET,http://dev.make-them-think.org/tabular/pages/index/$json_trans,true);
   data_request.send();
 }


  var bgcolor="99FFCC";
  var chgcolor="#CC00FF";
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
foreach ($transactions AS $t) {
$i=0;
 foreach ($t['data'] as $td){
  $rowstyle = ($i++%2==0) ? "row1" : "row2";
  $amount = $td['amount']/100;
  $created = $td['created'];
  $memo = $td['memo'];
  $merchant = $td['merchant'];

  if ($td['userid']==$_SESSION['userid']) {
    echo "<tr class='$rowstyle' onmouseout='changeback(this);' onmouseover='change(this);'><td>$created</td><td>\$$amount&nbsp;</td><td>$memo&nbsp;</td><td>$merchant</td></tr>\n";
  }
  else
    echo "<tr class='$rowstyle'><td>$created</td><td>\$$amount&nbsp;</td><td>$memo&nbsp;</td><td>$merchant</td></tr>\n";
  } 
 }
}
?>
</tbody>
</table>
</div>
