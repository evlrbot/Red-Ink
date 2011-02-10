<script type="text/javascript">
$(document).ready(function() {
    $(".nav img.rollover").hover(function(){ this.src=this.src.replace("_1","_2") },function(){ this.src=this.src.replace("_2","_1") });
    $("#subnav img.rollover").hover(function(){ this.src=this.src.replace("_1","_2") },function(){ this.src=this.src.replace("_2","_1") });

});
</script>

<!-- START NAV -->
<div id="nav">
<img src="/system/application/img/nav/red-ink-logo-white.png" alt="Red Ink" class='logo'/>
<ul>
<li><a href='/main'>About</a></li>
<li><a href='/wiki/Blog/Index'>Blog</a></li>
<li><a href='/main/development'>Development</a></li>
<li><a href='/main/privacy'>Privacy</a></li>
|
<li><a href='/<?= $this->auth->access() ? 'logout':'login';?>'><?= $this->auth->access() ? 'Logout':'Login';?></a></li>
</ul>
</div>
<!-- END NAV -->

<?php if( $this->auth->access() ) { ?>
<!-- START SUB NAV -->
<div id="subnav">
<ul>
<li><a href="/me"><img src="/system/application/img/subnav/linechart.png"/>Dashboard</a></li>
<li><a href="/campaign"><img src="/system/application/img/subnav/tags.png"/>Campaigns</a></li>
<li><a href="/me/shoeboxes"><img src="/system/application/img/subnav/shoebox.png"/>Shoeboxes</a></li>
<li><a href="/me/account"><img src="/system/application/img/subnav/gear.png"/>Settings</a></li>
</ul>
</div>
<!-- END SUB NAV -->
<?php } ?>