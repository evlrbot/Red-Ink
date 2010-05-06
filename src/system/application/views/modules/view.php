<h1><?=$module['name']?> <a href="/campaign/edit/<?=$module['id']?>" class="small">edit</a></h1>
<p><?=$module['description']?></p>
<?php $this->module->load($module['id']); ?>