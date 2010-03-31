<?php

	echo "<li>$viz[name] - <a href='/visualization/add/$modid/$viz[id]'>add</a></li>";
   
   	echo renderChartHTML("/system/application/libraries/$viz[multidata]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);


?>