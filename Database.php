<?php

class Database {
  private $connection;

  public function __construct() {
    global $config;
    $this->connection = new mysqli($config['host'], $config['user'], $config['pass'], $config['name']);
    if ($this->connection->connect_error) {
      echo "Connection failed: " . $this->connection->connect_error;
      exit;
    }
    $this->query("SET NAMES 'ut8'");
  }

  public function query($sql) {
    return $this->connection->query($sql);
  }

  public function insertNewUser($chatId) {
    global $config;
    $sql = "INSERT INTO " . $config['table'] . " VALUES ('" . $chatId . "', '0')";
    $this->query($sql);
  }

  public function getUserCounter($chatId) {
    global $config;
    $result = $this->query("SELECT _countMsg FROM " . $config['table'] . " WHERE _chatId LIKE '" . $chatId . "'");
    $countMsg = $result->fetch_array()['_countMsg'] + 1;
    $this->query("UPDATE " . $config['table'] . " SET _countMsg = '" . $countMsg . "' WHERE _chatId = '" . $chatId . "'");
    return $countMsg;
  }
}
