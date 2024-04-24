<?php

require_once __DIR__. '/../core/cred.php';

/**
 * Connection class to establish database connection.
 */
class DatabaseConnection {
  /**
    * Variable to set servername.
    */
  private $servername;
  /**
    * Variable to set username.
    */
  private $username;
  /**
    * Variable to set password.
    */
  private $password;
  /**
    * Variable to set database name.
    */
  private $dbname;
  /**
   * Variable to establishing connection.
   *
   * @var \PDO
   */
  private $conn;

  /**
   * Constructor to establish database connection.
   */
  public function __construct() {
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
  /**
   * Get the established database connection.
   *
   * @return \PDO The database connection object.
   */
  public function getConnection() {
    return $this->conn;
  }
}
