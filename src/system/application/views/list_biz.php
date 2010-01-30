<h1>Businesses <a href='' class='small'>add</a></h1>
<ul id="userlist">
<?php
foreach($bizs AS $b) {
   echo "<li>$b[name]<br/>$b[address1]<br/>$b[address2]<br/>$b[city], $b[state] $b[zip]</li>";
}
?>
</ul>