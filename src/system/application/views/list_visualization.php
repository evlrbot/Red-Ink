<h1>Visualizations</h1>

<ul id="list">

<?php

foreach($vizs AS $v) {

   echo "<li>$v[name] - <a href='/visualization/add/$modid/$v[id]'>add</a></li>";

   if($v['name']== 'Bubble Chart (XY Plot Chart)') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Multiple Series Area Chart') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Multiple Series Column Chart 2D') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Multiple Series Horizontal Bar Chart 3D') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Multiple Series Horizontal Bar Chart 2D') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Combination Chart - Multiple Series Vertical Column 3D with Dual Y Trendline') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/combo.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Combination Chart - Multiple Series Vertical Column 3D with Singe Y Trendline') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/combo.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Combination Chart - Multiple Series Column and Area combination with Singe Y Trendline') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/combo.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Combination Chart - Multiple Series Column and Area Combination 2D with Dual Y Trendline') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/combo.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Multiple Series Line Chart') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Multiple Series Stacked Vertical Column 2D Chart') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/combo.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Combination Chart - Multiple Series Stacked Column 2D with Dual Y Trendline') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/combo.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Scatter Chart (XY plot)') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/combo.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Scrolling Chart - Area 2D') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/combo.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Scrolling Chart - Vertical Column 2D') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/combo.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Scrolling Chart - Vertical Column and Area Chart 2D and Single Y Trendline') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/combo.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Scrolling Chart - Line 2D') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/single.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Scrolling Chart - Combination Vertical Column and Area 2D with Dual Y Trendline') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/combo.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Scrolling Chart - Multiple Series Stacked Column 2D') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Stacked Area Chart2D') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Stacked Horizontal Bart Chart 2D') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Stacked Horizontal Bar Chart 3D') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Stacked Vertical Column 2D') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Stacked Vertical Column 3D') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Stacked Vertical Column Chart 3D with Dual Y Trendline') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/combo.xml", "", "chart", 700, 300, false);
   }

   else if($v['name']== 'Multiple Series Vertical Column Chart 3D') {   
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/multi.xml", "", "chart", 700, 300, false);
   }

   else {
   	echo renderChartHTML("/system/application/libraries/$v[template]", "/system/application/libraries/single.xml", "", "chart", 700, 300, false);
   }
}


?>

</ul>