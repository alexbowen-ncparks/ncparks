<?php
declare(strict_types=1);
namespace DPR\API\Infrastructure\Persistence\DAO;

use DPR\API\Infrastructure\Persistence\DBPool;

class DAOFactory {
  private $DBPool;

  public function __construct(DBPool $DBPool) {
    $this->DBPool = $DBPool;
  }

  public function __get($property): DAO {
    $className = 'DPR\\API\\Infrastructure\\Persistence\\DAO\\'.$property;

    return new $className($this->DBPool);
  }
}