<html>
<head>
<script type="text/javascript">
  function makeTable(data) {
    // make table and table body
    var body = document.getElementsByTagName("body")[0];
    var tbl  = document.createElement("table");
    var tblbody=document.createElement("tbody");
    var tblhead=document.createElement("thead");
 
   //creating header cells
   var headrow= document.createElements("tr");
   var headers = ["name", "dollar amount", "date", "memo/merchant"];

   for (var k = 0; k<4;k++) {

     var cell = document.createElement("td");
     var cellText=document.createTextNode(headers[k]);
     cell.appendChild(cellText);
     headrow.appendChild(cell);
     tblhead.appendChild(headrow);
   }
	
   //creating cells
   for (var p = 0;<?php p<$num_numbers ?>;p++) {
     // creates a number of rows
     var row = document.createElement("tr");

     for (var i = 0; i<4; i++) {
	// creates cells ( name, dollar, date, memo) and appends to table
	var cell = document.createElement("td");
	var cellText = document.createTextNode('');
	cell.appendChild(cellText);
	row.appendchild(cell);
     }
  
     // add row to the table body
     tblbody.appendChild(row);   
  }
  
  // append head and body into table and adds a border
  tbl.appendChild(tblhead);
  tbl.appendChild(tblbody);
  tbl.setAttribute("border", "1");
}
</script>
</head>
<body onload="makeTable">
</body>
</html>
 
