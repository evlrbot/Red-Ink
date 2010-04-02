<?php

	echo "<li>$viz[name] - <a href='/visualization/add/$modid/$viz[id]'>add</a></li>";

	  $colors= array('FF0000', '00FF00', '0000FF', 'AA0000', '0E2964');
	  shuffle($colors);
	  $palette_colors= implode(",", $colors);
	
	$xml= 
"<chart caption='Sample Viz' bgColor= 'FFFFFF' plotGradientColor='' showBorder= '0' showValues='0' numberPrefix='$' canvasbgColor='000000' canvasBorderColor='000000' canvasBorderThickness='2' showPlotBorder='0' useRoundEdges='1' canvasBorderThickness= '0' chartTopMargin= '0' paletteColors= '$palette_colors'>
	<styles>
		<definition>
			<style name='Title' type='font' face='Arial' size='15' color='000000' bold='1'/>
			<style name='Labels' type='font' face='Arial' size='15' color='000000' bold='1'/>
			<style name='Values' type='font' face='Arial' size='13' color='000000' bold='0'/>
			<style name='YValues' type='font' face='Arial' size='24' color='000000' bold='1'/>
			<style name='Bevel' type='bevel' distance='0'/>
			<style name='Shadow' type='shadow' angle='45' distance='0'/>
		</definition>
		<application>
			<apply toObject='Caption' styles='Title' />
			<apply toObject='Datalabels' styles='Values' />
			<apply toObject='Datavalues' styles='Values' />         
			<apply toObject='Xaxisname' styles='Labels' />
			<apply toObject='Yaxisname' styles='YValues' />
			<apply toObject='Yaxisvalues' styles='Values' />            		
			<apply toObject='DataPlot' styles='Bevel, Shadow' />
		</application>    
	  </styles>

   <categories>
      <category label='Jan' />
      <category label='Feb' />
      <category label='Mar' />
      <category label='Apr' />
      <category label='May' />
      <category label='Jun' />
      <category label='Jul' />
      <category label='Aug' />
      <category label='Sep' />
      <category label='Oct' />
      <category label='Nov' />
      <category label='Dec' />
   </categories>

   <dataset seriesName='2006' >
      <set value='27400' />
      <set value='29800' />
      <set value='25800' />
      <set value='26800' />
      <set value='29600' />
      <set value='32600' />
      <set value='31800' />
      <set value='36700' />
      <set value='29700' />
      <set value='31900' />
      <set value='34800' />
      <set value='24800' />
   </dataset>

   <dataset seriesName='2005'>
      <set value='10000' />
      <set value='11500' />
      <set value='12500' />
      <set value='15000' />
      <set value='11000' />
      <set value='9800'  />
      <set value='11800' />
      <set value='19700' />
      <set value='21700' />
      <set value='21900' />
      <set value='22900' />
      <set value='20800' />
   </dataset>

</chart>";
	
	
   
   	echo renderChartHTML("/system/application/libraries/$viz[multidata]", "", "$xml", "chart", 700, 300, false);


?>