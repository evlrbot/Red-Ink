<h1>Businesses <a href='/business/add' class='small'>add</a></h1>
<ul id="userlist">
<?php
foreach($bizs AS $b) {
   echo "<li><em>$b[name]</em><br/>$b[address1]<br/>";
   echo empty($b['address2']) ? "":"$b[address2]<br/>";
   echo "$b[city], $b[state] $b[zip]<br/><a href='/business/edit'>edit</a></li>";
}
?>
</ul>