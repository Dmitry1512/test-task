<?php

namespace Lgr;

class Logger extends \Psr\Log\AbstractLogger {

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
