<?php
echo "<h1>$module[name]</h1>";
echo "<p style='text-align:center; font-size:1.2em;'>$module[description]</p>";
$this->module->load($module['id']);
?>