<h1>Consumers</h1>
<ul id="userlist">
<?php
foreach($users AS $u) {
   echo "<li>$u[email]";
}
?>
</ul>