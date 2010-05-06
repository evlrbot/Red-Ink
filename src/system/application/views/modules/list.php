<h1>Campaigns <a href="/campaign/create" class="small">add</a></h1>
<ul id="modulelist">
<?php
foreach($data AS $mod) {
   echo "<li><em><a href='/campaign/view/$mod[id]'>$mod[name]</a></em><br/>$mod[description]<br/>";
   echo "<a href='/campaign/add/$mod[id]'>Add</a> &nbsp;&nbsp;&nbsp;<a href='/campaign/remove/$mod[id]'>Remove</a> <!--&nbsp;&nbsp;&nbsp;<a href='/campaign/delete/$mod[id]'>Delete</a>--> &nbsp;&nbsp;&nbsp;<a href='/campaign/edit/$mod[id]'>Edit</a></li>";
}
?>
</ul>