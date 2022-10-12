<?php
echo "<html><head>";
?>
<script language='JavaScript'>
function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}
</script>
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

<script>
    $(function() {
        $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });
</script>

<style>
a:link{text-decoration:none; color:#009900;}

.ui-datepicker {
  font-size: 80%;
}
textarea { font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; color:black; }

td { font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; color:gray; }
th { font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; color:green; }
</style>
<?php
echo "</head><body>";
?>