<ul id='user_nav'>
<li>Individual Account Profile</li>
<ul>
<li><a href='/me'>My Dashboard</a></li>
<li><a href='/me/account'>Account Info</a></li>
<li><a href='#'>Badges</a></li>
</ul>
<li>Organization Account Profile</li>
<ul>
<li><a href='/organization'>Our Dashboard</a></li>
<li><a href='/organization/account'>Account Info</a></li>
</ul>
<li>Campaign Manager</li>
<ul>
<li><a href='/campaign/create'>Start New Campaign</a></li>
<li><a href='/campaign/index'>Search Campaigns</a></li>
<li><em>Organizer:</em></li>
<ul>
<li><a href='#'>Spending Habits in Cambridge, MA</a></li>
</ul>
<li><em>Participant:</em></li>
<ul>
<?php
foreach($modules AS $mod) {
   echo "<li><a href='/campaign/view/$mod[id]'>$mod[name]</a></li>";
}
?>
</ul>
</ul>
</ul>