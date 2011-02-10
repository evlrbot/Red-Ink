<?php
echo "<ul id='user_modules'>";
foreach($modules as $m) {
  $m = $this->module->get_module($m['modid']);
  echo "<li onclick='goto($m[id])'><img src='/system/application/img/subnav/dashboard.png' alt='Dashboard'/><a href='#'>$m[name]</a><p/>$m[description]</p></li>";
}
echo "</ul>";
?>