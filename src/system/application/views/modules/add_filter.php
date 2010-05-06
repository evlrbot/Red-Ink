<h1><a class='small' href='<?=site_url()."filters/add"?>'>New</a>  Filters <a class='small' href='<?=site_url()."campaign/edit/$module_id"?>'>Back</a></h1>
<ul id="filter_list">
<?php
foreach($filters AS $b) {
   echo "<li><em>$b[name]</em><br/>$b[address1]<br/>";
   echo empty($b['address2']) ? "":"$b[address2]<br/>";
   echo "$b[city], $b[state] $b[zip1]";
   echo !empty($b['zip2']) ? "-$b[zip2]<br/>" : '<br/>';
   echo "<a href='".site_url()."campaign/add_filter/$module_id/$b[id]'>add</a>";
   echo "</li>";
}
?>
</ul>