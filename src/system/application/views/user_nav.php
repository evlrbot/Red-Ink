<ul id='user_nav'>
<li>Account Profile</li>
<ul>
<li><a href='/me'>My Dashboard</a></li>
<li><a href='/me/account'>Account Info</a></li>
</ul>
<li>Campaign Manager</li>
<ul>
<li><a href='/campaign/create'>Start New Campaign</a></li>
<li><a href='/campaign/index'>Search Campaigns</a></li>
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