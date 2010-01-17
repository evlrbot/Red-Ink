<h1>Campaigns</h1>
<ul id="modulelist">
<?php
foreach($data AS $mod) {
   echo "<li><em><a href='/campaign/view/$mod[id]'>$mod[name]</a>:</em> $mod[description]";
   echo "<br/><a href='/campaign/add/$mod[id]'>Activate</a> &nbsp;&nbsp;&nbsp;<a href='/campaign/remove/$mod[id]'>De-Activate</a></li>";
}
?>
</ul>