<?php

require_once __DIR__ . '/../vendor/autoload.php';
/**
 * Class to represent use of Dotenv class.
 */
class Dotenv {
  /**
   * Constructor for the Dotenv class.
   * Loads env variables from the .env file.
   */
  public function __construct() {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
  }
}
