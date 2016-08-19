<?php

namespace Lgr;

class LoggerTransportMysql extends LoggerTransport {

    public function __construct($hostName, $userName, $password, $dbName, $tableName) {
        $this->tableName = $tableName;
        $this->dbConn = new \mysqli($hostName, $userName, $password, $dbName);
        if ($this->dbConn->connect_errno) {
            printf("Failed to connect to database: %s\n", $this->dbConn->connect_error);
            exit();
        }
        if (!$this->dbConn->set_charset('utf8')) {
            printf("Error loading character set utf8: %s\n", $this->dbConn->error);
            exit();
        }
        $checkTable = "CREATE TABLE IF NOT EXISTS $tableName (
            time timestamp default CURRENT_TIMESTAMP,
            level text,
            message text
            )";
        if (!$this->dbConn->query($checkTable)) {
            printf("Failed to create table: %s\n", $this->dbConn->error);
            exit();
        }
    }

    public function __destruct() {
        $this->dbConn->close();
    }

    public function writeToLog($logTime, $level, $message) {
        $message = addslashes($message);
        $logEntry = "INSERT INTO {$this->tableName} (level, message) VALUES ('$level', '$message')";
        if (!$this->dbConn->query($logEntry)) {
            printf("Error: %s\n", $this->dbConn->error);
        }
    }
}
