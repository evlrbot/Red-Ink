<h1>Filters <a href='/filters/add' class='small'>add</a></h1>
<ul id="filter_list">
<?php
foreach($filters AS $b) {
   echo "<li><em>$b[name]</em><br/>$b[address1]<br/>";
   echo empty($b['address2']) ? "":"$b[address2]<br/>";
   echo "$b[city], $b[state] $b[zip1]";
   echo !empty($b['zip2']) ? "-$b[zip2]<br/>" : '<br/>';
   echo "<a href='/filters/edit/$b[id]'>edit</a>";
   echo "<a href='/filters/deactivate/$b[id]'>de-activate</a>";
   echo "<a href='/filters/delete/$b[id]'>delete</a>";
   echo "</li>";
}
?>
</ul>