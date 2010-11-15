<?php
echo "<ul id='user_modules'>";
foreach($modules as $m) {
  $m = $this->module->get_module($m['modid']);
  //print_r($m);
  echo "<li>$m[name]</li>";
}
echo "</ul>";
?>