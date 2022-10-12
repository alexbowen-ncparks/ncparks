<?php
/*
Important Full Date and Time:

    * r: Displays the full date, time and timezone offset. It is equivalent to manually entering date("D, d M Y H:i:s O")

Time:

    * a: am or pm depending on the time
    * A: AM or PM depending on the time
    * g: Hour without leading zeroes. Values are 1 through 12.
    * G: Hour in 24-hour format without leading zeroes. Values are 0 through 23.
    * h: Hour with leading zeroes. Values 01 through 12.
    * H: Hour in 24-hour format with leading zeroes. Values 00 through 23.
    * i: Minute with leading zeroes. Values 00 through 59.
    * s: Seconds with leading zeroes. Values 00 through 59.

Day:

    * d: Day of the month with leading zeroes. Values are 01 through 31.
    * j: Day of the month without leading zeroes. Values 1 through 31
    * D: Day of the week abbreviations. Sun through Sat
    * l: Day of the week. Values Sunday through Saturday
    * w: Day of the week without leading zeroes. Values 0 through 6.
    * z: Day of the year without leading zeroes. Values 0 through 365.

Month:

    * m: Month number with leading zeroes. Values 01 through 12
    * n: Month number without leading zeroes. Values 1 through 12
    * M: Abbreviation for the month. Values Jan through Dec
    * F: Normal month representation. Values January through December.
    * t: The number of days in the month. Values 28 through 31.

Year:

    * L: 1 if it's a leap year and 0 if it isn't.
    * Y: A four digit year format
    * y: A two digit year format. Values 00 through 99.

Other Formatting:

    * U: The number of seconds since the Unix Epoch (January 1, 1970)
    * O: This represents the Timezone offset, which is the difference from Greenwich Meridian Time (GMT). 100 = 1 hour, -600 = -6 hours
*/
echo date("m/d/y",time());echo "<br />";
$today_date=date("Y_md_hMM");
echo $today_date;echo "<br />";
//$tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));


$today=date("ymd_His ");
$curr_time=date("His");
echo $today;
echo $curr_time;
  
?>