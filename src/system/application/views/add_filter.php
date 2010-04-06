<h1>Filters <a class='small' href='<?=site_url()."dataset/edit/$modid/$dataset_id"?>'>Back</a></h1>
<ul id="bizlist">
<?php
foreach($bizs AS $b) {
   echo "<li><em>$b[name]</em><br/>$b[address1]<br/>";
   echo empty($b['address2']) ? "":"$b[address2]<br/>";
   echo "$b[city], $b[state] $b[zip1]";
   echo !empty($b['zip2']) ? "-$b[zip2]<br/>" : '<br/>';
   echo "<a href='".site_url()."dataset/addfilter/$dataset_id/$b[id]/$modid'>add</a>";
   echo "</li>";
}
?>
</ul>