
<script type='text/javascript'>

	
	function sum(){ 

        var val = document.getElementById('userInput').value;

        var temp = val.split(",");

        var total = 0;

        var v;

        for(var i = 0; i < temp.length; i++) {

          v = parseFloat(temp[i]);

          if (!isNaN(v)) total += v; 

        } 

        document.getElementById('resultSumValue').value = total; 

      } 
	
	
</script>

<table>
<tr>
<td>
<form id="input">

      <textarea id="userInput" rows="5" cols="100" placeholder="Enter numbers separated by comma Example: 1,2,3"></textarea> 

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








