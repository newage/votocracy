<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Application;
use App\Entity\User;
use App\Exception\NotFoundException;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ApplicationHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResourceGenerator $resourceGenerator,
        private readonly HalResponseFactory $responseFactory
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /* Not found application exception */
        if ($request->getAttribute('id') != 1) {
            throw NotFoundException::application(
                'Application with this id is not found',
                ['id' => $request->getAttribute('id')]
            );
        }

        $application = new Application();
        $application->setId(1);
        $application->setMessage('application');
        $application->setUser(
            (new User())->setId(1)->setName('test')
        );

        $resource = $this->resourceGenerator->fromObject($application, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }
}
