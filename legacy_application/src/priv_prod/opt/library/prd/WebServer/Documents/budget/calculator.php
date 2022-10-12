
<script type='text/javascript'>

	
	function sum(){ 

        var val = document.getElementById('userInput').value;
        val = val.replace(/,/g,'');
        var temp = val.split("+");

        var total = 0;

        var v;

        for(var i = 0; i < temp.length; i++) {

          v = parseFloat(temp[i]);

          if (!isNaN(v)) total += v; 

        } 
		
		var total = total.toFixed(2)
		var total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		
        document.getElementById('resultSumValue').value = total; 

      } 
	
	
</script>

<table align="center">
<tr>
<td>
<form id="input">

      <textarea id="userInput" rows="5" cols="100" placeholder="Example> Type: 1+2+3  Click: ADD"></textarea> 

      <input id="Run" type=Button value="ADD" onClick="sum()" />

    </form>
</td>
<td>
    <form id="resultSum">

      <input id="resultSumValue" type="text" />

 </form>
 </td>
 </tr>
 </table>








