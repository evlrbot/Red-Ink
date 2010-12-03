<h1>Campaigns <a href="/campaign/create" class="small">add</a></h1>
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

