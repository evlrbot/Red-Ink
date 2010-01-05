<html>
<head>
<title>Login</title>
<style type="text/css" media="all">
@import url("/mainstyle.css");
</style>
<script language="javascript" src="/jquery-1.3.2.min.js" ></script>
<script language="javascript">
$(document).ready(function() {
   $("#username").focus( function(){ 
      if($(username).val() == "Username") {
         $(username).val("");
      }   
   });
   $("#username").blur( function(){
      if($(username).val() == "") {
         $(username).val("Username");
      }   
   });
   $("#password").focus( function(){ 
      if($(password).val() == "Password") {
         $(password).val("");
      }   
   });
   $("#password").blur( function(){
      if($(password).val() == "") {
         $(password).val("Password");
      }   
   });
   $("#submit").click( function(){
      $("#loginform").validate();
   });

});
</script>
</head>
<body>

<?php
$attr = array('id'=>'loginform','method'=>'GET');
echo form_open('Login/auth',$attr);
$attr = array('id'=>'username','name'=>'username','value'=>'Username');
echo form_input($attr);
echo br();
$attr = array('id'=>'password','name'=>'password','value'=>'Password');
echo form_password($attr);
$attr = array('value'=>'Login','id'=>'submit');
echo br();
echo form_submit($attr);
echo br();
echo isset($errmsg) ? $errmsg : '';
?>
<p>If you don't have a login, you may sign-up for one <a href="/RegisterUser">here</a>.
<p>h3ll0</p>
<?php
echo form_close();
?>
<p id="rendertime">Page rendered in {elapsed_time} seconds.</p>
</body>
</html>
