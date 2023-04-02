<?php

declare(strict_types=1);

namespace App\Handler;

use Common\Service\EventBusInterface;
use EventBus\DTO\User;
use EventBus\Event\EventSerializer;
use EventBus\Event\UserRegistrationEvent;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EventProduceHandler implements RequestHandlerInterface
{
    public function __construct(private readonly EventBusInterface $eventBus)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestId = '9df8gyd785gf';
        $event = new UserRegistrationEvent();
        $event->setRequestId($requestId);
        $event->setCreationTime(new \DateTime());
        $event->setData([(new User())->setId(1)->setName('Test')->setEmail('no@no.no')]);

        $json = (new EventSerializer())->serialize($event);

        $response = $this->eventBus->produce($json, ['X-Request-Id' => $requestId]);
        return new JsonResponse(['code' => $response]);
    }
}
