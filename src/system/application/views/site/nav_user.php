<ul class='divider'>
<li><a href='/me'>My Dashboard</a></li>
<li><a href='/me/account'>My Account</a></li>
<li><a href='/filters/'>Filters</a></li>
<li><a href='/campaign/index'>Campaigns</a></li>
<ul>
<?php
foreach($modules AS $mod) {
   if(isset($mod['id']) ) {
     echo "<li><a href='/campaign/view/$mod[id]'>$mod[name]</a></li>";
   }
}
?>
</ul>
</ul>