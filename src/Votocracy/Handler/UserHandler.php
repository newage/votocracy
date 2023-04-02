<?php

declare(strict_types=1);

namespace Votocracy\Handler;

use Votocracy\Entity\User;
use Votocracy\Exception\NotFoundException;
use Laminas\Paginator\Adapter\ArrayAdapter;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UserHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResourceGenerator $resourceGenerator,
        private readonly HalResponseFactory $responseFactory
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /* Not found user exception */
        if ($request->getAttribute('id') != 1) {
            throw NotFoundException::user('User with this id is not found', ['id' => $request->getAttribute('id')]);
        }

        $entity = new User();
        $entity->setId(1);
        $entity->setEmail('test');

        $resource = $this->resourceGenerator->fromObject($entity, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }
}
