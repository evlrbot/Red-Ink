<head>
<script type="text/javascript">
<!--  
 function invite_popup() {
    window.open("http://dev.make-them-think.org/invite/","Invite", "status=1, height=600, width=1100 resizable=0")
}
//-->
</script>
</head>
<body>

<h1><?=$module['name']?> <a href="/campaign/edit/<?=$module['id']?>" class="small">edit</a></h1>
<?php $this->module->load($module['id']);?>


<!--invitation button  -->

<form>
<input type="button" onClick="invite_popup()" value="Invite Friends">
</form>
</body>
