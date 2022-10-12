<?php

$database = 'job_fair';
$db = 'job_fair';
$dbname = 'job_fair';

include("../../include/iConnect.inc");
//include("../no_inject.php");

mysqli_select_db($connection,$database);

//IF (isset($_POST["submit"]))
{
  //$submit_array = $_POST["submit"];
  //IF(!empty($submit_array))
  {
    //$microtime_sub = microtime(TRUE);
    $ip_address_sub = $_SERVER["REMOTE_ADDR"];
    $full_name = $_POST["element_4_1"] . $_POST["element_4_2"];
    $address1a = $_POST["element_7_1"];
    $address1b = $_POST["element_7_2"];
    $city1 = $_POST["element_7_3"];
    $state1 = $_POST["element_7_4"];
    $zip_code1 = intval($_POST["element_7_5"]);
    $country1 = $_POST["element_7_6"];
    $address2a = $_POST["element_7a_1"];
    $address2b = $_POST["element_7a_2"];
    $city2 = $_POST["element_7a_3"];
    $state2 = $_POST["element_7a_4"];
    $zip_code2 = intval($_POST["element_7a_5"]);
    $country2 = $_POST["element_7a_6"];
    $phone_number = intval($_POST["element_6_1"] . $_POST["element_6_2"] . $_POST["element_6_3"]);
    $email_address = $_POST["element_9"];
    $sex = $_POST["element_18"];
    $veteran_status = $_POST['element_18b'];
    $college = $_POST['element_8'];
    $major = $_POST['element_10'];
    $gpa = floatval($_POST['element_11']);
    $year_status = $_POST['element_19'];
    $year_graduated = intval($_POST['element_12']);
    $degree = $_POST['element_13'];
    $job_interest = $_POST['element_15'];
    $internship = $_POST['element_22'];
    $volunterr = $_POST['element_21'];
    $hours = $_POST['element_21a'];
    $park = $_POST['element_21b'];
    $referred_by = $_POST['element_14'];
    $comments = $_POST['element_16'];
    $event_sign_up = $_POST['element_21c'];

    $sql = "INSERT INTO job_fair.contact_submission(ip_address_sub,
                                            full_name,
                                            address1a,
                                            address1b,
                                            city1,
                                            state1,
                                            zip_code1,
                                            country1,
                                            address2a,
                                            address2b,
                                            city2,
                                            state2,
                                            zip_code2,
                                            country2,
                                            phone_number,
                                            email_address,
                                            sex,
                                            veteran_status,
                                            college,
                                            major,
                                            gpa,
                                            year_status,
                                            year_graduated,
                                            degree,
                                            job_interest,
                                            internship,
                                            volunteer,
                                            hours,
                                            park,
                                            referred_by,
                                            comments,
                                            event_sign_up
                                          )
            VALUES ('$ip_address_sub',
                    '$full_name',
                    '$address1a',
                    'address1b',
                    '$city1',
                    '$state1',
                    '$zip_code1',
                    '$country1',
                    '$address2a',
                    '$address2b',
                    '$city2',
                    '$state2',
                    '$zip_code2',
                    '$country2',
                    '$phone_number',
                    '$email_address',
                    '$sex',
                    '$veteran_status',
                    '$college',
                    '$major',
                    '$gpa',
                    '$year_status',
                    '$year_graduated',
                    '$degree',
                    '$job_interest',
                    '$internship',
                    '$volunteer',
                    '$hours',
                    '$park',
                    '$referred_by',
                    '$comments',
                    '$event_sign_up'
                  )
          ";    
    $result = @mysqli_query($connection,$sql) or die();
    $connection->close();
  }  
}


/*
$exten="jobfairdata";
$tm=microtime(TRUE);

function rx($i) {
  #$o=preg_replace("/[^a-zA-Z0-9\/_|+ .-]/", ' ', $i);
  $o=preg_replace("/[^a-zA-Z0-9\/_|+@. ]/", ' ', $i);
  #$o=preg_replace("/[^A-Za-z0-9 ]/", ' ', $i);
  #$o=preg_replace("/[^[:alnum:][:space:]]/u", '', $o);
  return $o;
 }

$fil = fopen("/opt/library/job_fair_data/" . $tm . "." . $exten, "w") or die("An error has occured.  Please press 'back' and try again.");

# first group short three items
fwrite($fil, "microtime=" . $tm . "\n");
fwrite($fil, "ip_addr=" . rx($_SERVER['REMOTE_ADDR']) . "\n");
fwrite($fil, "first_name=" . rx($_POST["element_4_1"]) . "\n");

fwrite($fil, "last_name=" . rx($_POST["element_4_2"]) . "\n");
fwrite($fil, "addr1=" . rx($_POST["element_7_1"]) . "\n");
fwrite($fil, "addr2=" . rx($_POST["element_7_2"]) . "\n");
fwrite($fil, "city=" . rx($_POST["element_7_3"]) . "\n");
fwrite($fil, "state=" . rx($_POST["element_7_4"]) . "\n");

fwrite($fil, "zip=" . rx($_POST["element_7_5"]) . "\n");
fwrite($fil, "country=" . rx($_POST["element_7_6"]) . "\n");
fwrite($fil, "area_code=" . rx($_POST["element_6_1"]) . "\n");
fwrite($fil, "exchange=" . rx($_POST["element_6_2"]) . "\n");
fwrite($fil, "extension=" . rx($_POST["element_6_3"]) . "\n");

fwrite($fil, "email=" . rx($_POST["element_9"]) . "\n");
 # male=1 female=2
fwrite($fil, "sex=" . $_POST["element_18"] . "\n");
//fwrite($fil, "race=" . $_POST["element_18a"] . "\n");
fwrite($fil, "veteran=" . $_POST["element_18b"] . "\n");
fwrite($fil, "college=" . rx($_POST["element_8"]) . "\n");
fwrite($fil, "major=" . rx($_POST["element_10"]) . "\n");
fwrite($fil, "gpa=" . rx($_POST["element_11"]) . "\n");

 # freshman,sophomore,junior,senior,alum 12345
fwrite($fil, "year_status=" . rx($_POST["element_19"]) . "\n");
fwrite($fil, "year_graduated=" . rx($_POST["element_12"]) . "\n");
fwrite($fil, "degree=" . $_POST["element_13"] . "\n");
 # yes=1 no=2
fwrite($fil, "hbcu=" . $_POST["element_20"] . "\n");
fwrite($fil, "job_interest=" . $_POST["element_15"] . "\n");

fwrite($fil, "internship=" . $_POST["element_22"] . "\n");
fwrite($fil, "volunteer=" . $_POST["element_21"] . "\n");
fwrite($fil, "hours=" . $_POST["element_21a"] . "\n");
fwrite($fil, "park=" . $_POST["element_21b"] . "\n");
fwrite($fil, "referred_by=" . rx($_POST["element_14"]) . "\n");

fwrite($fil, "comments=" . rx($_POST["element_16"]) . "\n");
fwrite($fil, "eventsignup=" . $_POST["element_21c"] . "\n");
fwrite($fil, "addr1a=" . rx($_POST["element_7a_1"]) . "\n");
fwrite($fil, "addr2a=" . rx($_POST["element_7a_2"]) . "\n");
fwrite($fil, "citya=" . rx($_POST["element_7a_3"]) . "\n");

fwrite($fil, "statea=" . rx($_POST["element_7a_4"]) . "\n");
fwrite($fil, "zipa=" . rx($_POST["element_7a_5"]) . "\n");
fwrite($fil, "countrya=" . rx($_POST["element_7a_6"]) . "\n");
#fwrite($fil, "=" . rx($_POST[""]) . "\n");

fclose($fil);
*/
header("Location: thankyou.html");
#fwrite($fil, "=" . $_POST[""] . "\n");
?>


