<?php
echo "<ul id='user_modules_carousel' style='height:130px; margin-bottom: 40px; width:900px; left:3.25%;'>";
foreach($modules as $m) {
  $m = $this->module->get_module($m['modid']);
  echo "<li onclick='goto($m[id])' style='float:left; list-style:none; margin:10px; border:0px solid red; padding:20px; height:100px; border:0px solid red; width:250px; -moz-border-radius:5px; border:1px solid #999; background-color:#DDD;'><img src='/system/application/img/subnav/dashboard.png' alt='Dashboard'/><a href='#'>$m[name]</a><p/>$m[description]</p></li>";
}
echo "</ul>";
?>