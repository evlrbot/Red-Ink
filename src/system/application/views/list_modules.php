<h1>Campaigns</h1>
<ul id="modulelist">
<?php
foreach($data AS $mod) {
  echo "<li><em><a href='/campaign/view?id=$mod[id]'>$mod[name]</a>:</em> $mod[description]</li>";
}
?>
</ul>