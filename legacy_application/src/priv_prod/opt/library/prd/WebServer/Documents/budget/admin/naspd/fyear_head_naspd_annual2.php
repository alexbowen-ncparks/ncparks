<?php

// echo "<br />Hello fyear_head_naspd_annual2.php";
// exit;
// echo "<br /> fiscal_year = $f_year<br />";

// $f_year = "";
/*
$query3 = "SELECT py1
            FROM fiscal_year
            WHERE active_year = 'y'
         ";
*/
$query3 = "SELECT py1
            FROM fiscal_year
            WHERE report_year like '2021'
         ";
$result3 = mysqli_query($connection, $query3)
         OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query3:<br />$query3<br />");
$row3 = mysqli_fetch_array($result3);
extract($row3);      //brings back max (fiscal_year) as $fiscal_year

// $f_year == '';

/*
echo "<br /> Fiscal year: $f_year
      <br /> Past Fiscal Year: $py1
      <br /> Row3: $row3[0]
      <br />
      ";
*/

IF ($f_year == '')
{
   $f_year = $py1;
}

//Replace static Fiscal year Menu Bar with "dynamically produced menu".  This will automatically change in the NEW Fiscal year when MoneyCounts Administrator changes the "active_year" in TABLE=fiscal_year (bass 12/9/19)

/*
$query5b = "SELECT cy,
                  py1,
                  py2,
                  py3,
                  py4
            FROM fiscal_year
            WHERE active_year = 'y'
         ";
*/
$query5b = "SELECT cy,
                  py1,
                  py2,
                  py3,
                  py4
            FROM fiscal_year
            WHERE report_year like '2021'
            ";

// echo "<br />query5b = $query5b<br />";
$result5b = mysqli_query($connection, $query5b)
         OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5b:<br />$query5b<br />");
$num5b = mysqli_num_rows($result5b);

echo "<table border='5' cellspacing='5' align='center'>";

while ($row5b = mysqli_fetch_array($result5b))
{
   echo "<tr>";

   $checkmark_image = "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";

   extract($row5b);
   // echo "<br />$cy, $py1, $py2, $py3, $py4<br />";
   // echo "<br />report_type: $report_type<br />";
   // echo "<br />fiscal_year: $f_year<br />";
   // echo "<br />py1: $py1<br />";

   IF ($report_type == 'form')
   {
      echo "<br />py1 == $py1<br />";
      IF ($py1 == $f_year)
      {
         $py1_td = "<td>
                     <a href='naspd_annual.php?report_type=$report_type&f_year=$py1'>
                        <font class=cartRow>
                           $py1 $checkmark_image
                        </font>
                     </a>
                  </td>
                  ";
      }
      
      IF ($py1 != $f_year)
      {
         $py1_td = "<td>
                     <a href='naspd_annual.php?report_type=$report_type&f_year=$py1'>
                        $py1
                     </a>
                  </td>
                  ";
      }
   }
   IF ($report_type != 'form')
   {
      IF ($py1 == $f_year)
      {
         $py1_td = "<td>
                     <a href='naspd_annual.php?report_type=$report_type&f_year=$py1'>
                        <font class=cartRow>
                           $py1 $checkmark_image
                        </font>
                     </a>
                  </td>
                  ";
      }
      
      IF ($py1 != $f_year)
      {
         $py1_td = "<td>
                     <a href='naspd_annual.php?report_type=$report_type&f_year=$py1'>
                        $py1
                     </a>
                  </td>
                  ";
      }

      IF ($py2 == $f_year)
      {
         $py2_td = "<td>
                     <a href='naspd_annual.php?report_type=$report_type&f_year=$py2'>
                        <font class=cartRow>
                           $py2 $checkmark_image
                        </font>
                     </a>
                  </td>
                  ";
      }

      IF ($py2 != $f_year)
      {
         $py2_td = "<td>
                     <a href='naspd_annual.php?report_type=$report_type&f_year=$py2'>
                        $py2
                     </a>
                  </td>
                  ";
      }

      IF ($py3 == $f_year)
      {
         $py3_td = "<td>
                     <a href='naspd_annual.php?report_type=$report_type&f_year=$py3'>
                        <font class=cartRow>
                           $py3 $checkmark_image
                        </font>
                     </a>
                  </td>
                  ";
      }

      IF ($py3 != $f_year)
      {
         $py3_td = "<td>
                     <a href='naspd_annual.php?report_type=$report_type&f_year=$py3'>
                        $py3
                     </a>
                  </td>
                  ";
      }

      IF ($py4 == $f_year)
      {
         $py4_td = "<td>
                     <a href='naspd_annual.php?report_type=$report_type&f_year=$py4'>
                        <font class=cartRow>
                           $py4 $checkmark_image
                        </font>
                     </a>
                  </td>
                  ";
      }

      IF ($py4 != $f_year)
      {
         $py4_td = "<td>
                     <a href='naspd_annual.php?report_type=$report_type&f_year=$py4'>
                        $py4
                     </a>
                  </td>
                  ";
      }
   }

   echo "$cy_td";
   echo "$py1_td";
   echo "$py2_td";
   echo "$py3_td";
   echo "$py4_td";
   echo "</tr>";
}

echo "</table>";

?>