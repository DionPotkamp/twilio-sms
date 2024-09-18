<?php
namespace App\Utils;

use Exception;

/**
 * @method debug(string $logEntry)
 * @method info(string $logEntry)
 * @method notice(string $logEntry)
 * @method warning(string $logEntry)
 * @method error(string $logEntry)
 * @method critical(string $logEntry)
 * @method alert(string $logEntry)
 * @method emergency(string $logEntry)
 *
 * A simple logger class that writes log entries to a file.
 */
class Logger
{
    private string $logFile;
    private array $allowedLevels = ['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'];
    /**
     * Constructor
     *
     * @param string $filePath Path to the log file
     */
    public function __construct(string $filePath)
    {
        $this->logFile = $filePath;
    }

    /**
     * Handle dynamic method calls for logging.
     *
     * @param string $name      The method name called (e.g., debug, info, error)
     * @param array  $arguments The arguments passed to the method
     */
    public function __call(string $name, array $arguments)
    {
        $level = strtolower($name);

        if (!in_array($level, $this->allowedLevels)) {
            $level = 'info';
        }

        // The first argument is the log message
        $message = $arguments[0] ?? 'undefined';

        $timestamp = date('Y-m-d H:i:s');

        $logEntry = sprintf("[%s] %s %s\n", $timestamp, $level, $message);

        try {
            file_put_contents($this->logFile, $logEntry, FILE_APPEND | LOCK_EX);
        } catch (Exception) {
            // Silently ignore to prevent disrupting the app
            error_log("Logger Error: Unable to write to log file $this->logFile. Message: $message");
        }
    }
}
