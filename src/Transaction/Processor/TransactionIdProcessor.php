<?php

declare(strict_types=1);

namespace Bipro\Logging\Transaction\Processor;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

/**
 * Class TransactionIdProcessor
 * @package Bipro\Logging\Transaction\Processor
 */
final class TransactionIdProcessor implements ProcessorInterface
{
    private string $transactionId;

    /**
     * TransactionIdProcessor constructor.
     *
     * @param string $transactionId
     */
    public function __construct(string $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @param LogRecord $record
     *
     * @return LogRecord The processed record
     */
    public function __invoke(LogRecord $record): LogRecord
    {
        $record->extra['transaction_id'] = $this->transactionId;

        return $record;
    }
}
