<script type="text/javascript">
$(document).ready(function() {
    $(".nav img.rollover").hover(function(){ this.src=this.src.replace("_1","_2") },function(){ this.src=this.src.replace("_2","_1") });
    $("#subnav img.rollover").hover(function(){ this.src=this.src.replace("_1","_2") },function(){ this.src=this.src.replace("_2","_1") });

});
</script>

<!-- START NAV -->
<div class="nav">
<div style="width:1000px; margin:0px auto; text-align:right;">
<img src="/system/application/img/nav/redink_logo.jpg" alt="Red Ink" style="float:left;"/>
<a href='/main'><img src="/system/application/img/nav/about_1.jpg" alt="About" class="rollover"/></a>
<a href='#'><img src="/system/application/img/nav/blog_1.jpg" alt="Blog" class="rollover"/></a>
<a href='/main/development'><img src="/system/application/img/nav/development_1.jpg" alt="Development" class="rollover"/></a>
<a href='/main/privacy'><img src="/system/application/img/nav/privacy_1.jpg" alt="Privacy" class="rollover"/></a>
<img src="/system/application/img/nav/divider.jpg"/>
<a href='/<?= $this->auth->access() ? 'logout':'login';?>'><img src="/system/application/img/nav/<?= $this->auth->access() ? 'logout_1.jpg':'login_1.jpg';?>" class="rollover"/></a>
</div>

</div>
<!-- END NAV -->

<?php if( $this->auth->access() ) { ?>
<!-- START SUB NAV -->
<div id="subnav">
<p>Welcome, <?=$email?></p>
<div class='rule'>&nbsp;</div>
<ul>
<li><a href="/me"><img src="/system/application/img/subnav/linechart.png"/>Dashboard</a></li>
<li><a href="/campaign"><img src="/system/application/img/subnav/tags.png"/>Campaigns</a></li>
<li><a href="#"><img src="/system/application/img/subnav/shoebox.png"/>Shoeboxes</a></li>
<li><a href="/me/account"><img src="/system/application/img/subnav/gear.png"/>Settings</a></li>
</ul>
</div>
<!-- END SUB NAV -->
<?php } ?>