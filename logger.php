<?php

class Logger
{
    private static $instance;
    private $logFile;
    private $level;
    private $maxFileSize;
    private $logFormat;

    const LEVELS = ['debug', 'info', 'warning', 'error'];

    private function __construct($filePath, $level = 'debug', $maxFileSize = 1048576, $logFormat = "[{date}] [{level}]: {message}")
    {
        $this->logFile = $filePath;
        $this->level = $level;
        $this->maxFileSize = $maxFileSize;
        $this->logFormat = $logFormat;
        $this->rotateLogFile();
    }

    public static function getInstance($filePath = __DIR__ . '/app.log', $level = 'debug', $maxFileSize = 1048576, $logFormat = "[{date}] [{level}]: {message}")
    {
        if (self::$instance === null) {
            self::$instance = new self($filePath, $level, $maxFileSize, $logFormat);
        }
        return self::$instance;
    }

    private function rotateLogFile()
    {
        if (file_exists($this->logFile) && filesize($this->logFile) >= $this->maxFileSize) {
            $backupFile = $this->logFile . '.' . time();
            rename($this->logFile, $backupFile);
        }
    }

    public function log($level, $message)
    {
        if (array_search($level, self::LEVELS) < array_search($this->level, self::LEVELS)) {
            return;
        }

        $date = new DateTime();
        $formattedMessage = str_replace(
            ['{date}', '{level}', '{message}'],
            [$date->format('Y-m-d H:i:s'), strtoupper($level), $message],
            $this->logFormat
        );

        file_put_contents($this->logFile, $formattedMessage . PHP_EOL, FILE_APPEND);
    }

    public function debug($message)
    {
        $this->log('debug', $message);
    }

    public function info($message)
    {
        $this->log('info', $message);
    }

    public function warning($message)
    {
        $this->log('warning', $message);
    }

    public function error($message)
    {
        $this->log('error', $message);
    }
}

// Exemple d'utilisation
$logger = Logger::getInstance(__DIR__ . '/app.log', 'info');

// Journaliser des messages à différents niveaux
$logger->debug('Ceci est un message de débogage.');
$logger->info('Ceci est un message d\'information.');
$logger->warning('Ceci est un avertissement.');
$logger->error('Ceci est une erreur.');
