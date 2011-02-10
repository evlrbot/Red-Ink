<?php
echo "<ul id='user_modules_carousel'>";
foreach($modules as $m) {
  $m = $this->module->get_module($m['modid']);
  echo "<li onclick='goto($m[id])'><img src='/system/application/img/subnav/dashboard.png' alt='Dashboard'/>$m[name]</li>";
}
echo "</ul>";
?>