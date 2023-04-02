<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Application;
use App\Entity\ApplicationCollection;
use App\Entity\User;
use App\Exception\NotFoundException;
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

        $adapter = new ArrayAdapter([
            (new Application())
                ->setId(1)
                ->setMessage('application'),
            (new Application())
                ->setId(2)
                ->setMessage('test'),
            (new Application())
                ->setId(3)
                ->setMessage('test application')
                ->setCollection(new ApplicationCollection(
                    new ArrayAdapter([
                        (new Application())
                            ->setId(1)
                            ->setMessage('application'),
                        (new Application())
                            ->setId(2)
                            ->setMessage('test')
                    ])
                )),
        ]);

        $applicationCollection = new ApplicationCollection($adapter);

        $entity->setApplications($applicationCollection);

        $resource = $this->resourceGenerator->fromObject($entity, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }
}
