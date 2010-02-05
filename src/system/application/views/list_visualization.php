<h1>Visualizations</h1>
<ul id="list">
<?php
foreach($vizs AS $v) {
   echo "<li>$v[name] - <a href='/visualization/add/$modid/$v[id]'>add</a></li>";
}
?>
</ul>