<?php

namespace Lgr;

class LoggerTransportStdout extends LoggerTransport {

    public function writeToLog($logTime, $level, $message) {
        $logEntry = "$logTime $level: $message\n\n";
        printf($logEntry);
    }
}
