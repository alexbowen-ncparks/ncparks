<!DOCTYPE html>
<html>
<body>

Radio button:
<input type="radio" id="myRadio1" name='test' value='blue'>blue
<input type="radio" id="myRadio2" name='test' value='red'>red


<input type="radio" id="myRadio3" name='test1' value='yellow'>yellow
<input type="radio" id="myRadio4" name='test1' value='green'>green


<button onclick="myFunction()">Try it</button>

<p id="demo"></p>

<script>
function myFunction() 
{
      var group = document.getElementsByTagName("input");

        for ( var i = 0; i < group.length; i++) {
               group.item(i).checked=true;
              
    }
}
</script>

</body>
</html>