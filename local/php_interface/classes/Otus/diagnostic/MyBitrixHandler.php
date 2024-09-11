<?php
/**
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Otus\Diagnostic;

use Bex\Monolog\Handler\BitrixHandler;
use Monolog\Logger;
use Bex\Monolog\Formatter\BitrixFormatter;

/**
 * Monolog handler for the event log of Bitrix CMS.
 *
 * @author Nik Samokhvalov <nik@samokhvalov.info>
 */
class MyBitrixHandler extends BitrixHandler
{
    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        $lines = explode("<br><br>", $record['formatted']['message']);

        foreach ($lines as &$line) {
            $line = 'Otus - ' . $line;
        }

        $record['formatted']['message'] = implode("<br><br>", $lines);

        \CEventLog::Log(
            $record['formatted']['level'],
            $this->getEvent(),
            $this->getModule(),
            $record['formatted']['item_id'],
            $record['formatted']['message'],
            $this->getSite()
        );
    }
}
