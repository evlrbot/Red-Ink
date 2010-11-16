<?php
echo "<ul id='user_modules'>";
foreach($modules as $m) {
  $m = $this->module->get_module($m['modid']);
  echo "<li><img src='/system/application/img/subnav/dashboard.png' alt='Dashboard'/><a href='#' onclick='goto($m[id])'>$m[name]</a><p/>$m[description]</p></li>";
}
echo "</ul>";
?>