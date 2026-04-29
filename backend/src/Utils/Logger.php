<?php
// src/Utils/Logger.php
namespace App\Utils;

class Logger {
    private $logFile;

    public function __construct($logFile) {
        $this->logFile = $logFile;
    }

    public function log($action, $userId, $details = '') {
        $date = date('Y-m-d H:i:s');
        $entry = "[$date] user_id=$userId action=$action details=$details\n";
        file_put_contents($this->logFile, $entry, FILE_APPEND);
    }
}
