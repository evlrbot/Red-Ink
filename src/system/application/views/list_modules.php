<h1>Campaigns</h1>
<ul id="modulelist">
<?php
foreach($data AS $mod) {
  echo "<li><em><a href='/campaign/view/$mod[id]'>$mod[name]</a>:</em> $mod[description]</li>";
}
?>
</ul>