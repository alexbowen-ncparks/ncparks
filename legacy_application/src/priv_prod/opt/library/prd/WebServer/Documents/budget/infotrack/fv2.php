<?php
	//define present value
	$presentValue = 38000;
 
//define interest rate per compounding period
	$intRate = 11;
 
	//define number of compounding periods
	$numPeriods = 13;
	 
	//calculate future value assuming compound interest
	//result: "100000 @ 8 % over 6 periods becomes 158687.43"
	$futureValue = round($presentValue * pow(1 + ($intRate/100),
	$numPeriods), 2);
    //$monthly60=pymt(.11/12,240,147564.65);
	echo "$presentValue @ $intRate % over $numPeriods periods becomes 
	$futureValue";
    //echo $monthly60;



echo "<br /><br />";
$result= $presentValue * pow((1 + .11),13);
echo $result;


	?>