<?php
namespace Otus\Diagnostic;

use Bitrix\Main\Diag;

class MyFileExceptionHandlerLog extends Diag\FileExceptionHandlerLog
{
    /**
     * @param \Throwable $exception
     * @param int $logType
     */
    public function write($exception, $logType)
    {
        $text = Diag\ExceptionHandlerFormatter::format($exception, false, $this->level);

        $context = [
            'type' => static::logTypeToString($logType),
        ];

        $logLevel = static::logTypeToLevel($logType);

        $message = "{date} - Host: {host} - {type} - {$text}\n";
        $lines = explode("\n", $message);

        foreach ($lines as &$line) {
            $line = 'Otus - ' . $line;
        }

        $message = implode("\n", $lines);
        $this->logger->log($logLevel, $message, $context);
    }
}