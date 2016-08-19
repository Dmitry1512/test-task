<?php

namespace Lgr;

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
