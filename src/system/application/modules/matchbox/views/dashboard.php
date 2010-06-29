<html>
<head>
<title>Welcome to Matchbox</title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

.warning {
 background: url('<?php echo $base_url; ?>icons/exclamation') no-repeat 8px 8px;
 border: 1px solid #eb8a71;
 background-color: #ffebe8;

 margin: 14px 0 14px 0;
 padding: 8px 6px 8px 30px;
}

#donations {
 background: url('<?php echo $base_url; ?>icons/coins') no-repeat 8px 8px;
 border: 1px solid #ffe222;
 background-color: #fff8cc;

 margin: 14px 0 14px 0;
 padding: 8px 6px 8px 30px;
}

p span {
  font-size: 0.7em;
}

</style>
</head>
<body>

<h1>Welcome to Matchbox!</h1>

<?php if(!$strict): ?><p class="warning"><strong>Notice:</strong> Strict Mode is <em>disabled</em>. If you don't know what this means, consult the <?php echo $wiki; ?>.</p><?php endif; ?>

<p id="donations">If you use and enjoy Matchbox, please consider <a href='http://www.pledgie.com/campaigns/5871?canvas=false'>making a donation</a>.<br />
<?php echo $raised; ?>Many thanks for your continued support.</p>

<p>The module you are looking at is being generated dynamically by CodeIgniter using Matchbox.</p>

<p>If you would like to edit this page you'll find it located at:</p>
<code><?php echo $filepath; ?>views/dashboard.php</code>

<p>The corresponding controller for this page is found at:</p>
<code><?php echo $filepath; ?>controllers/dashboard.php</code>

<p>If you are using Matchbox for the very first time, you should start by reading the <?php echo $wiki; ?>.</p>

<p>If you have any questions, join the <a href="http://codeigniter.com/forums/viewthread/128084/">Discussion</a>.</p>


<p><br />Page rendered in {elapsed_time} seconds (don't worry, high render time due to Pledgie example library).</p>

<p>Icons by <a href="http://www.famfamfam.com/lab/icons/silk/">famfamfam</a>.</p>

</body>
</html>