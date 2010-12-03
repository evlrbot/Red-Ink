<head>
<script type="text/javascript">
<!--  
 function invite_popup() {

window.open("http://dev.make-them-think.org/invite/index/<?=$module['id']?>","Invite", "scrollbars=yes status=1, height=480,width=435 resizable=0")
}
//-->
</script>
</head>
<body>

<h1><?=$module['name']?> <a href="/campaign/edit/<?=$module['id']?>" class="small">edit</a></h1>
<?php $this->module->load($module['id']);?>
