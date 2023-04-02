<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Application;
use App\Entity\User;
use App\Exception\ValidationException;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\InputFilter\InputFilterInterface;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ApplicationsPostHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResourceGenerator $resourceGenerator,
        private readonly HalResponseFactory $responseFactory,
        private readonly InputFilterInterface $inputFilter
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->inputFilter->setData($request->getParsedBody());
        if (!$this->inputFilter->isValid()) {
            throw ValidationException::wrongParameter('Validation error', $this->inputFilter->getMessages());
        }

        $hydrator = new ClassMethodsHydrator();
        $application = $hydrator->hydrate($this->inputFilter->getValues(), new Application());

        $application->setId(1);
        $application->setUser(
            (new User())->setId(1)->setName('test')
        );

        $resource = $this->resourceGenerator->fromObject($application, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }
}
