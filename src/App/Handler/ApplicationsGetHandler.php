<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Application;
use App\Entity\ApplicationCollection;
use Laminas\Paginator\Adapter\ArrayAdapter;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ApplicationsGetHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResourceGenerator $resourceGenerator,
        private readonly HalResponseFactory $responseFactory
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $page = $request->getQueryParams()['page'] ?? 1;
        $limit = $request->getQueryParams()['limit'] ?? 10;

        $adapter = new ArrayAdapter([
            (new Application())
                ->setId(1)
                ->setMessage('application'),
            (new Application())
                ->setId(2)
                ->setMessage('test'),
            (new Application())
                ->setId(3)
                ->setMessage('test application'),
            (new Application())
                ->setId(4)
                ->setMessage('test application'),
            (new Application())
                ->setId(5)
                ->setMessage('test application'),
        ]);

        $applicationCollection = new ApplicationCollection($adapter);
        $applicationCollection->setItemCountPerPage($limit);
        $applicationCollection->setCurrentPageNumber($page);

        $resource = $this->resourceGenerator->fromObject($applicationCollection, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }
}
