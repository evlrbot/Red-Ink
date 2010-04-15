<?php include("./system/application/libraries/FusionCharts.php"); ?>
<html>
<head>
<title>Dynamic Page Name</title>
<style type="text/css" media="all">
@import url("/system/application/css/mainstyle.css");
</style>
<script language="javascript" src="/system/application/js/jquery-1.3.2.min.js" ></script>
<script language="javascript" src="/system/application/libraries/jquery.flot.min.js" ></script>
<script language="javascript" src="/system/application/js/jquery.form.js" ></script>
<script language="javascript">
$(document).ready(function(){});
</script>
</head>
<body>

<div id="site_nav">
<span class="sitelinks">
<em>Red Ink</em> |
<a href="/me">Home</a>
<a href="http://www.make-them-think.org/Blog/Index" target="_blank">Blog</a>
<a href="http://www.make-them-think.org/Help/Index" target="_blank">Help</a>  
<a href="/campaign/index">Campaigns</a>
<a href="/consumer/index">Consumers</a>
<a href="/business/index">Businesses</a>
</span>
<span class="logout">
<?=$email;?> |
<a href="/logout">Logout</a></span>
</div>
