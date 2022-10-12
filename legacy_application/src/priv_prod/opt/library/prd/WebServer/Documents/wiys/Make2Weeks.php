<?php
function get_weekdates($year, $month, $day)
	{
	
	  // make unix time
	  $searchdate = mktime(0,0,0,$month,$day,$year);
	  //echo "Searchdate: $searchdate<br>";
	
	  // lets get the day of week
	  $day_of_week = strftime("%u", $searchdate); 
	  //echo "Debug: $day_of_week <br><br>";
	  
	  $days_to_firstday = ($day_of_week - 1);
	  //echo "Debug: $days_to_firstday <br>";
	/*
	  $days_to_lastday = (7 - $day_of_week);
	  //echo "Debug: $days_to_lastday <br>";
	*/
	  $days_to_lastday = (14 - $day_of_week);
	  //echo "Debug: $days_to_lastday <br>";
	
	  $date_firstday = strtotime("-".$days_to_firstday." days", $searchdate);
	  //echo "Debug: $date_firstday <br>";
	
	  $date_lastday = strtotime("+".$days_to_lastday." days", $searchdate);
	  //echo "Debug: $date_lastday <br>";
	
	  $d_result = "";
	 
	  // write an array of all dates for the 2 weeks 
	  //for($i=0; $i<=6; $i++) {
	  for($i=0; $i<=13; $i++)
		  {
		   $y = $i + 1;
		   $d_date = strtotime("+".$i." days", $date_firstday);
		  
		   // feel free to add more values to these hashes
		 $result[$y]['year'] = strftime("%Y", $d_date);
		   $result[$y]['month'] = strftime("%m", $d_date);
		   $result[$y]['day'] = strftime("%d", $d_date);
		//$result[$y]['dayname'] = strftime("%A", $d_date);
		   $result[$y]['shortdayname'] = strftime("%a", $d_date);
		//   $result[$y]['sqldate'] = strftime("%Y-%m-%d", $d_date);
		  }
	
	  return $result;
	}
?>