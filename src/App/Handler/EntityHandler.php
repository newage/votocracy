<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Application;
use Laminas\Diactoros\Response\TextResponse;
use Laminas\Hydrator\ClassMethodsHydrator;
use Mezzio\Hal\HalResource;
use Mezzio\Hal\Link;
use Mezzio\Hal\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EntityHandler implements RequestHandlerInterface
{
    public function __construct(private readonly JsonRenderer $renderer)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $entity = new Application();
        $entity->setId(1);
        $entity->setMessage('entity message');

        $hydrator = new ClassMethodsHydrator();
        $hydrator->extract($entity);

        $link = new Link('application', '/api/application');
        $resource = new HalResource($hydrator->extract($entity), [$link]);

        return new TextResponse(
            $this->renderer->render($resource),
            200,
            ['Content-Type' => 'application/hal+json']
        );
    }
}
