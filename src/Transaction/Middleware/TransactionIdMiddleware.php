<?php

declare(strict_types=1);

namespace Bipro\Logging\Transaction\Middleware;

use Bipro\Logging\Transaction\Processor\TransactionIdProcessor;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

/**
 * Class TransactionIdMiddleware
 * @package Bipro\Logging\Transaction\Middleware
 */
final class TransactionIdMiddleware implements MiddlewareInterface
{
    private const HEADER = 'X-DEMV-Transaction-Id';
    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     * @throws Throwable
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $transactionId = !empty($request->getHeader(self::HEADER)[0]) ? $request->getHeader(self::HEADER)[0] : 'unbekannt';
        $this->logger->pushProcessor(new TransactionIdProcessor($transactionId));

        return $handler->handle($request);
    }
}
