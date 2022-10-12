
<script>
document.getElementById("misc_table").tBodies[0].innerHTML += "<tr>";

var header1=<?php echo "$pass_header";?>

document.getElementById("misc_table").tBodies[0].innerHTML += "<tr>";
for (i=0;i<header1.length;i++)
	{
	document.getElementById("misc_table").tBodies[0].innerHTML += "<td><b>" + header1[i] + "</b></td>";
	}
document.getElementById("misc_table").tBodies[0].innerHTML += "</tr>";
	

function updateVar(a)
	{
	
var count=a;

for (var i=1;i<=count;i++)
		{
		document.getElementById("misc_table").tBodies[0].innerHTML += "<tr><td>"+i+"</td>";
		for (var j=0; j<header1.length; j++)
			{
			var field_name=header1[j] + "[misc]" + "[]";
		
			if(header1[j]=="condition")
				{
				document.getElementById("misc_table").tBodies[0].innerHTML += "<td><select name='" + field_name + "'>";
				document.getElementById("misc_table").tBodies[0].innerHTML += "<option value=''></option>\n";
				document.getElementById("misc_table").tBodies[0].innerHTML += "<option value='Poor'>Poor</option>\n";
				document.getElementById("misc_table").tBodies[0].innerHTML += "<option value='Fair'>Fair</option>\n";
				document.getElementById("misc_table").tBodies[0].innerHTML += "<option value='Good'>Good</option>\n";
				document.getElementById("misc_table").tBodies[0].innerHTML += "<option value='Very Good'>Very Good</option>\n";
				document.getElementById("misc_table").tBodies[0].innerHTML += "</select></td>";
				}
				else
				{
				if(header1[j]=="fas_num")
					{var_fn="NA"; var_size="3"; var_ro="READONLY";}
					else
					{var_fn=""; var_size="20"; var_ro="";}
			document.getElementById("misc_table").tBodies[0].innerHTML += "<td><input type='text' name='" + field_name + "' value=\"" +var_fn + "\" size=\"  "+ var_size + "\"" + var_ro  + "></td>";
				}
			}
	
		}
	document.getElementById("misc_table").tBodies[0].innerHTML += "</tr>";
	}
</script>