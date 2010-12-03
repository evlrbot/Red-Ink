<h1>Campaigns <a href="/campaign/create" class="small">add</a></h1> 
<p>Campaigns coordinate sharing and analysis of data across many users . A campaign defines sets of filters which are used to search for transactions from its member's profiles. That aggregate data is looked at in total and used for visualization and analysis.</p>

<p><b>A campaign can only access your information if you join it.</b> If you believe in the reason for the campaign, and don't mind sharing the information it asks for, then join. If you are not comfortable with what it is asking for, do not join. It is as simple as that.</p>

<p>A campaign will <b>NEVER</b> have access to your data without your <b>explicit approval</b>.</p>

<p>Create your own campaigns using our <a href="/campaign/create" class="small">campaign editor</a> to define what you're looking for, how to visualize it, and how to promote it.</p>

<hr/>

<ul id="modulelist">
<?php
foreach($data AS $mod) {
   echo "<li><h1><a href='/campaign/view/$mod[id]'>$mod[name]</a></h1><p>This is what the campaign's creator's say about it:</p><p class='description'>$mod[description]</p>";
   echo "<p class='actions'><a href='/campaign/add/$mod[id]'>Join!</a> <a href='/campaign/edit/$mod[id]'>Edit</a></p></li>";
}
?>
</ul>
<!--
<b><em><a href="#" onclick="invite_popup()">Invite your friends to join you on Red Ink!</a></em></b>
//-->

