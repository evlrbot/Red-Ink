<div class="nav" style='margin:52px 10px 200px 13px'>
<div><span style='margin-left: 35px;'> <img src='http://www.make-them-think.org/uploads/Admin/redink.png' alt='' title='' /></span></div>
<?php $logged_in = $this->auth->access(); ?>
<ul>
<li><span class='login'><?= $logged_in ? "<a href='".site_url('logout')."'>LOGOUT</a>" : "<a href='".site_url('me')."'>LOGIN</a>";?></span></li>
</ul>
<?php 
if($logged_in) {
    $data['modules'] = array();
    $mods = $this->user->get_modules($_SESSION['userid']);
    foreach($mods AS $mod) {
      array_push($data['modules'],$this->module->get_module($mod['modid']));
    }
    $this->load->view('site/nav_user',$data);
    echo "<ul><li><span class='login'><img width='15px' src='".site_url('/system/application/img/redink_drop.png')."'></span></li></ul>";
}
?>
<ul>
<li><a href='http://www.make-them-think.org/Blog/Index'>Blog</a>
</li><li><a href='http://www.make-them-think.org/Main/Home'>Home</a>
</li><li><a href='http://www.make-them-think.org/Main/Download'>Download</a>
</li><li><a href='http://www.make-them-think.org/Documentation/Index'>Documentation</a>
</li><li><a href='http://www.make-them-think.org/Main/Credits'>Credits &amp; Contact</a>
</li><li><a href="#" onclick="popup('http://www.make-them-think.org/subscribe.php');">Mailing List</a>
</li>
</ul>

<ul><li><span class='login'><img width='15px' src='<?=site_url('/system/application/img/redink_drop.png')?>'></span></li></ul>

<div id="sponsors">
<h1>Sponsored in part by:</h1>
<a href='http://civic.media.mit.edu' target='_blank'><img src='/system/application/img/c4.jpg' alt='Center for Future Civic Media'></a>
<a href='http://knightfoundation.org' target='_blank'><img src='/system/application/img/knight.gif' alt='John S. and James L. Knight Foundation'></a>
<a href='http://media.mit.edu' target='_blank'><img src='/system/application/img/medialab.jpg' alt='MIT Media Lab'></a>
<a href='http://www.mit.edu' target='_blank'><img src='/system/application/img/mit_logo.png' alt='MIT'></a>
</div>

</div>
