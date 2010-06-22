<head>
<script type="text/javascript">
<!-- 
  function invite_popup(){
   window.open("http://dev.make-them-think.org/invite/", "Invite", "status=1, height=600, width=1100 resizable=0")
}
//-->
</script>
</head>

<h1>Campaigns <a href="/campaign/create" class="small">add</a></h1>
<ul id="modulelist">
<?php
foreach($data AS $mod) {
   echo "<li><em><a href='/campaign/view/$mod[id]'>$mod[name]</a></em><br/>$mod[description]<br/>";
   echo "<a href='/campaign/add/$mod[id]'>Add</a> &nbsp;&nbsp;&nbsp;<a href='/campaign/remove/$mod[id]'>Remove</a> &nbsp;&nbsp;&nbsp;<a href='/campaign/delete/$mod[id]'>Delete</a> &nbsp;&nbsp;&nbsp;<a href='/campaign/edit/$mod[id]'>Edit</a></li>";
}
?>
</ul>
<b><em><a href="#" onclick="invite_popup()">Invite your friends to join you on Red Ink!</a></em></b>
