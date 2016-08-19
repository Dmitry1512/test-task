<?php

namespace Lgr;

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
