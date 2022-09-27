<?php
declare(strict_types=1);
namespace DPR\API\Infrastructure\Persistence\DAO;

use DPR\API\Domain\Models;

class ExampleDAO extends DAO {

  protected $BaseQuery = "SELECT * FROM find.map ";



  function getById($id) {
    $DBConn = $this->DBPool->request();
    $DBConn->query($this->BaseQuery." WHERE true OR 1 = ?",
      array(
        array("value" => $id, "type" => \PDO::PARAM_INT)
      ));
    $File = null;
    if($DBConn->nextRow()) {
      $File = new Models\File($DBConn->getRow());
    }
    $this->DBPool->release($DBConn);
    return $File;
  }



  function getFiles() {
    $DBConn = $this->DBPool->request();
    $DBConn->query($this->BaseQuery);
    $Files = [];
    while($DBConn->nextRow()) {
      $Files[] = new Models\File($DBConn->getRow());
    }
    $this->DBPool->release($DBConn);
    return $Files;
  }

}
