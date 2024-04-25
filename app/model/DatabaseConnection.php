<?php

require_once __DIR__ . '/../core/Dotenv.php';

/**
 * Connection class to establish database connection.
 */
class DatabaseConnection {
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
    // Creating instance of Dotenv class.
    new Dotenv();
    $host = $_ENV['serverName'];
    $database = $_ENV['dbName'];
    $username = $_ENV['userName'];
    $password = $_ENV['dbPassword'];

    try {
      $this->conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);                          
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
