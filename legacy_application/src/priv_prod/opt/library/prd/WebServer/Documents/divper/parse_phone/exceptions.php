<?php 
		if($park_name=="WILLIAM B. U"){$park_name="UMSTEAD STATE PARK";}
		if($park_name=="KERR LAKE ST"){$park_name="KERR LAKE RECREATION";}
		if($park_name=="MEDOC MOUNTA"){$park_name="Medoc Mountain State Park";}
		if($park_name=="NORTH DISTRI"){$park_name="RALEIGH PARKS & REC";}
		if($park_name=="SOUTH DISTRI"){$park_name="RALEIGH PARKS & REC";}
		if($park_name=="NEW RIVER ST"){$park_name="NEW RIVER STATE PARK VISITOR";}
		if($park_name=="ELK KNOB STA"){$park_name="Elk Knob State Park";}
				
		if($park_name=="PARKS AND RE"){$park_name="Parks and Rec Radio Tech Offi";}
		
		if($park_name=="GORGES STATE"){
			$park_name="828-553-4508";
			$no_wan="<a href='divper/parse_phone/phone_detail.php?phone_number=828-553-4508&person=&billing_period=FEB%2028,%202009&open_file=$open_file'>$park</a>";}
			
		if($park_name=="CHIMNEY ROCK"){
			$park_name="828-625-1823";
			// get billing period
			$var=substr($bill_txt,0,700);
			$var=explode("Period ending - ",$var);
			$bp=explode("   :",$var[1]);
			//echo "<pre>"; print_r($bp); echo "</pre>"; // exit;
			$billing_period=$bp[0];
			$no_wan="<a href='/divper/parse_phone/phone_detail.php?phone_number=828-625-1823&person=&billing_period=$billing_period&open_file=$open_file'>$park</a>";}
			
	$link="<a href='/divper/parse_phone/phone_summary.php?park_name=$park_name&billing_period=$period_end&open_file=$open_file&submit=park'>$park</a>";
	
		if($park_name=="WEST DISTRIC"){$link="<a href='/divper/parse_phone/phone_detail.php?phone_number=704-528-6514&person=&billing_period=FEB%2028,%202009&open_file=$open_file' target='_blank'>WEDI</a> 2 Cell phones<br /><a href='/divper/parse_phone/phone_detail.php?phone_number=704-528-6514&person=&billing_period=FEB%2028,%202009&open_file=$open_file' target='_blank'>WEDI</a>";}
?>