
<script>
var header1=<?php echo "$pass_header";?>

var table = document.getElementById("misc_table");

// Create an empty <tr> element and add it to the 1st position of the table:
var row = table.insertRow(0);

// Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
//var cell1 = row.insertCell(0);
//var cell2 = row.insertCell(1);
for (i=0;i<header1.length;i++)
	{
	var cell1=row.insertCell(i);
	}
// Add some text to the new cells:
cell1.innerHTML = header1[0];
cell2.innerHTML = "NEW CELL2";
</script>