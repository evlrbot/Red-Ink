<head>
<script type="text/javascript">
<!--  
 function invite_popup() {
 
 <?php 
# $this->load->helper('url');
# $data=array('module_name'=>$module['name'],'module_description'=>$module['description']);
# $this->load->controller('invite',$data);
# $atts=array('width'=>'1100','height'=>'600','scrollbars'=>'yes','resizable'=>'yes');
#  echo anchor_popup('invite/$module['id']','',$atts);
?>

window.open("http://dev.make-them-think.org/invite/index/<?=$module['id']?>","Invite", "scrollbars=yes status=1, height=480,width=435 resizable=0")
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
