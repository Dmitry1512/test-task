<?php

require 'Classes/Psr/Log/LoggerInterface.php';
require 'Classes/Psr/Log/InvalidArgumentException.php';
require 'Classes/Psr/Log/AbstractLogger.php';
require 'Classes/Psr/Log/LogLevel.php';

abstract class LoggerTransport {
    abstract protected function writeToLog($logTime, $level, $message);
}

class LoggerTransportStdout extends LoggerTransport {

    public function writeToLog($logTime, $level, $message) {
        $logEntry = "$logTime $level: $message\n\n";
        printf($logEntry);
    }
}

class LoggerTransportFile extends LoggerTransport {

    public function __construct($logFilePath) {
        $this->logFile = fopen($logFilePath, 'a') or die('Failed to open log file!');
    }

    public function __destruct() {
        fclose($this->logFile);
    }

    public function writeToLog($logTime, $level, $message) {
        $logEntry = "$logTime $level: $message\r\n\r\n";
        fwrite($this->logFile, $logEntry);
    }
}

class LoggerTransportMysql extends LoggerTransport {

    public function __construct($hostName, $userName, $password, $dbName, $tableName) {
        $this->tableName = $tableName;
        $this->dbConn = new mysqli($hostName, $userName, $password, $dbName);
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

class Logger extends Psr\Log\AbstractLogger {

    public function __construct(LoggerTransport $transport) {
        $this->transport = $transport;
        if (!ini_get('date.timezone')) {
            date_default_timezone_set ('Europe/Moscow');
        }
    }

    private function messageToString($message, array $context = array()) {
        switch (gettype($message)) {
            case 'string':
                break;

            case 'array':
                $message = print_r($message, true);
                break;

            case 'object':
                if (method_exists($message, '__toString')) {
                    $message = (string) $message;
                } else {
                    $message = print_r($message, true);
                }
                break;

            default:
                $message = 'Unsupported message type. Only strings, arrays, objects and exceptions are allowed';
                break;
        }
        return $message;
    }

    public function log($level, $message, array $context = array()) {
        $logTime = date('Y-m-d H:i:s');
        if (method_exists($this, $level)) {
            strtolower($level);
            $this->transport->writeToLog($logTime, $level, $this->messageToString($message, $context));
        } else {
            throw new InvalidArgumentException('Unsupported log level');
        }
    }
}

class LoggerCreator {

    public static function create($type = 'stdout', $config = '') {

        switch (strtolower($type)) {
            case 'stdout':
                return new Logger(new LoggerTransportStdout);

            case 'file':
                return new Logger(new LoggerTransportFile($config));

            case 'mysql':
                $config = explode(' ', $config);
                return new Logger(new LoggerTransportMysql($config[0], $config[1], $config[2], $config[3], $config[4]));

            default:
                throw new Exception("Invalid logger type");
        }
    }
}
