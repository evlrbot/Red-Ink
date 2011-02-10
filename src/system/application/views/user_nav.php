
<ul id='user_nav'>
<li><a href='/me'>My Dashboard</a></li>
<li><a href='/me/account'>Account Info</a></li>
<li><a href='/campaign/index'>Campaigns</a></li>
<li><em>Participant:</em></li>
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
</ul>