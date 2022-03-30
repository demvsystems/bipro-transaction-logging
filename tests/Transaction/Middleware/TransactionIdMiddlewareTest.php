<?php

declare(strict_types=1);

namespace Tests\Bipro\Logging\Transaction\Middleware;

use Bipro\Logging\Transaction\Middleware\TransactionIdMiddleware;
use Bipro\Logging\Transaction\Processor\TransactionIdProcessor;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;

/**
 * Class TransactionIdMiddlewareTest
 * @package Bipro\Tests\Transaction\Middleware
 */
final class TransactionIdMiddlewareTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @throws Throwable
     */
    public function testProcess(): void
    {
        $logger        = new Logger('test');
        $middleware    = new TransactionIdMiddleware($logger);
        $transactionId = 'asfdsafd';
        $request       = (new ServerRequest())->withHeader('X-DEMV-Transaction-Id', $transactionId);
        $response      = $this->buildResponseHandler(new Response());
        $middleware->process($request, $response);
        $this->assertEquals(new TransactionIdProcessor($transactionId), $logger->getProcessors()[0]);
    }

    /**
     * @throws Throwable
     */
    public function testProcessTransactionIdNotSet(): void
    {
        $logger     = new Logger('test');
        $middleware = new TransactionIdMiddleware($logger);
        $request    = new ServerRequest();
        $response   = $this->buildResponseHandler(new Response());
        $middleware->process($request, $response);
        $this->assertEquals(new TransactionIdProcessor('unbekannt'), $logger->getProcessors()[0]);
    }

    /**
     * @param Response $response
     *
     * @return RequestHandlerInterface
     */
    private function buildResponseHandler(Response $response): RequestHandlerInterface
    {
        $mock = $this->prophesize(RequestHandlerInterface::class);
        $mock->handle(Argument::type(ServerRequestInterface::class))->willReturn($response);

        return $mock->reveal();
    }
}
