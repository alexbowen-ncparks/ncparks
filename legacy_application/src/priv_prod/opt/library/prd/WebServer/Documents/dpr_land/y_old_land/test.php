<!DOCTYPE html>
<html>
<body>

Radio button:
<input type="radio" id="myRadio1" name='test' value='blue'>blue
<input type="radio" id="myRadio2" name='test' value='red'>red

<p>Click the "Try it" button to find out whether the radio button is checked, or not.</p>

<button onclick="checkedRadioBtn(test)">Try it</button>

<p id="demo"></p>

<script>
function checkedRadioBtn(sGroupName)
    {
        var group = document.getElementsByName(sGroupName);

        for ( var i = 0; i < group.length; i++) {
               group.item(i).checked=true;
              
        }
    }
</script>

</body>
</html>