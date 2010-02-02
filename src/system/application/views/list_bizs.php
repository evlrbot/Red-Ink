<h1>Businesses <a href='/business/add' class='small'>add</a></h1>
<ul id="bizlist">
<?php
foreach($bizs AS $b) {
   echo "<li><em>$b[name]</em><br/>$b[address1]<br/>";
   echo empty($b['address2']) ? "":"$b[address2]<br/>";
   echo "$b[city], $b[state] $b[zip1]";
   echo !empty($b['zip2']) ? "-$b[zip2]<br/>" : '<br/>';
   echo "<a href='/business/edit/$b[id]'>edit</a>";
   echo "<a href='/business/deactivate/$b[id]'>de-activate</a>";
   echo "<a href='/business/delete/$b[id]'>delete</a>";
   echo "</li>";
}
?>
</ul>