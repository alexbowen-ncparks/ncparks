<script>
function item_tot_id(price,index)
	{
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
			document.getElementById("cost_" + x).value=tot;
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