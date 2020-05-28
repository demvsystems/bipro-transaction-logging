<?php

declare(strict_types=1);

namespace Bipro\Logging\Transaction\Processor;

use Monolog\Processor\ProcessorInterface;

/**
 * Class TransactionIdProcessor
 * @package Bipro\Logging\Transaction\Processor
 */
final class TransactionIdProcessor implements ProcessorInterface
{
    /**
     * @var string
     */
    private $transactionId;

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
     * @param array $record
     *
     * @return array The processed records
     */
    public function __invoke(array $record): array
    {
        $record['extra']['transaction_id'] = $this->transactionId;

        return $record;
    }
}
