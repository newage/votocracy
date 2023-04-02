<?php

declare(strict_types=1);

namespace Votocracy\Handler;

use Common\Service\EventBusInterface;
use EventBus\Event\UserRegistrationEvent;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EventConsumeHandler implements RequestHandlerInterface
{
    public function __construct(private readonly EventBusInterface $eventBus)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->eventBus->consume(function ($event) {
            if ($event instanceof UserRegistrationEvent) {
                return $event->getEventName();
            }
        });
        return new JsonResponse(['code' => $response]);
    }
}
