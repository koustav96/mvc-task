<?php

require_once __DIR__. '/../core/cred.php';

class DatabaseConnection
{
  private $servername;
  private $username;
  private $password;
  private $dbname;
  private $conn;

  public function __construct()
  {
    global $servername, $dbname, $username, $db_password;
    $this->servername = $servername;
    $this->dbname = $dbname;
    $this->username = $username;
    $this->password = $db_password;

    try {
      $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);

      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Connection failed: " . $e->getMessage());
    }
  }
  public function getConnection()
  {
    return $this->conn;
  }
}
