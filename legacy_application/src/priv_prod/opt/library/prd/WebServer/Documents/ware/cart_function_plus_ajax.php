<script>
function item_tot_id(price,index,pass_id)
	{
// 			alert("I am an alert box " + price + index);
	var number = "";
	var lol = document.getElementsByTagName('input');
	var grand_tot=0;
	for( var x = 0; x < lol.length; x++ )
		{
		var number = document.getElementById("quantity_" + x).value;
		var str_rep=number.replace(/,/, "");  // remove any commas
		var new_price = parseFloat(document.getElementById("price_" + x).value);
		var tot=(price*parseFloat(str_rep)).toFixed(2);
		grand_tot+=parseFloat(new_price*str_rep);
		if(x==index)
			{
// 			alert("I am an alert box " + number + " - " + pass_id);
			document.getElementById("cost_" + x).value=tot;
			
			if (window.XMLHttpRequest) {
				xmlhttp=new XMLHttpRequest();
				} else { // code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}

			xmlhttp.open("GET","ajax_cart_sql.php?q="+ number + "&id=" + pass_id,true);
				xmlhttp.send();
				this.form.submit();
	  
			}		
		document.getElementById("grand_sum").innerHTML=grand_tot.toFixed(2);
		}
	}
</script>
<style>
a:link{
text-decoration: none;
}
</style>