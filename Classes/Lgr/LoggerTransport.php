<?php

namespace Lgr;

abstract class LoggerTransport {
    abstract protected function writeToLog($logTime, $level, $message);
}
