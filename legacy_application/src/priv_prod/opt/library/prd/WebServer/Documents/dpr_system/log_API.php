<?php
/**
 * These APIs are used to get login data. Different paramaters get different information.
 * format for request: /dpr_system/log_API.php?type=<type>&app=<dbName>
 */
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$requestType = $_GET['type'];
$body;

switch($requestType){
  case "siteTotals":
    getSiteTotals();
    break;
  case "appTotals":
    getAppTotals();
    break;
  case "appData":
    getAppData($_GET['app']);
    break;
}

/**
 * Gets summary logins data
 * format: [{"visits":"3843","visitors":"330"}]
 */

function getSiteTotals()
{
  $sql = "SELECT COUNT(*) as visits, COUNT(DISTINCT loginName) as visitors 
    FROM divper.logins;";
  $database = "divper";
  include("../../include/iConnect.inc"); //connect to Maria server
  mysqli_select_db($connection, $database); //connect to db
  $result = mysqli_query($connection, $sql);
  //create an array
  $emparray = array();
  while($row =mysqli_fetch_assoc($result))
  {
      $emparray[] = $row;
  }
  $body = json_encode($emparray);
  http_response_code(200);
  echo $body;
  mysqli_close($connection);
};

/**
 * This gets the information for all logins across the site by app. It populates the body variable with this data in json format.
 * format: [{"dbName":"annual_pass","totalUsers":"6","totalVisits":"14"}, ...]
 */
function getAppTotals(){
  $sql = "SELECT dbName, COUNT(DISTINCT loginName) AS totalUsers, COUNT(*) AS totalVisits 
    from divper.logins 
    GROUP BY dbName 
    ORDER BY dbName;";
  $database = "divper";
  include("../../include/iConnect.inc");
  mysqli_select_db($connection, $database);
  $result = mysqli_query($connection, $sql);
  //create an array
  $emparray = array();
  while($row =mysqli_fetch_assoc($result))
  {
      $emparray[] = $row;
  }
  $body = json_encode($emparray);
  http_response_code(200);
  echo $body;
  mysqli_close($connection);
}

/**
 * gets the specific users and their info for a specific app
 * Returns only the data of users from divper.emplist, does not include non-dpr users currently
 * format: [{"loginName":"exampleName","accessLevel":"1","visits":"1","Fname":"first","Lname":"last","email":"example@ncparks.gov"}, ...]
 */
function getAppData($app){
  $sql = "SELECT 
  tb_1.loginName, 
      tb_1.accessLevel, 
      COUNT(*) AS visits, 
      tb_2.Fname,
      tb_2.Lname,
      tb_2.email
    FROM divper.logins tb_1 
    JOIN divper.empinfo tb_2 ON tb_1.loginName = tb_2.tempID 
    WHERE dbName='$app' 
    GROUP BY loginName
    ORDER BY visits DESC;";
    $database = "divper";
    include("../../include/iConnect.inc");
    mysqli_select_db($connection, $database);
    $result = mysqli_query($connection, $sql);
    //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    $body = json_encode($emparray);
    http_response_code(200);
    echo $body;
    mysqli_close($connection);
}

/*what do I want to see?
- Overview data:
  - How many total logins and unique vistors?
    - SELECT COUNT(*) as visits, COUNT(DISTINCT loginName) as visitors FROM divper.logins;
  - How many total unique visitors per app? and How many total visits to each app?
    - SELECT dbName, COUNT(DISTINCT loginName) AS totalUsers, COUNT(*) AS totalVisits from divper.logins GROUP BY dbName ORDER BY dbName;
  - How many unique users visit per user on average?
    - divide total visits by unique visitors
- Per App data
  - Be able to list unique visitors, their access level, and how many times they have visited it?
    - SELECT loginName, accessLevel, COUNT(*) AS visits FROM divper.logins WHERE dbName='<DATABASE_NAME>' GROUP BY loginName;
  - List data from before too
    - pass to new page from homepage so you don't have to query again

*/
