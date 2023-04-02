<?php

declare(strict_types=1);

namespace Common\Middleware;

use Common\Exception\AuthorizationException;
use Lcobucci\JWT\Token;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JwtMiddleware implements MiddlewareInterface
{
    protected $jwtFactory;

    public function __construct(callable $jwtFactory)
    {
        $this->jwtFactory = $jwtFactory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$request->hasHeader('authorization')) {
            throw AuthorizationException::invalidHeader('Does not exist `Authorization` header');
        }

        $bearer = $this->getBearerHeader($request->getHeader('authorization'));
        $token = ($this->jwtFactory)($bearer);

        return $handler->handle(
            $request->withAttribute(
                Token\DataSet::class,
                $token->claims()
            )
        );
    }

    protected function getBearerHeader(array $headers): string
    {
        if (is_string($headers[0]) && strstr($headers[0], ',')) {
            $headers = explode(',', $headers[0]);
        }

        foreach ($headers as $header) {
            $header = trim($header);
            if (strtolower(substr($header, 0, 6)) == 'bearer') {
                return substr($header, 7);
            }
        }
        throw AuthorizationException::invalidHeader('Does not exist `Bearer` token in `Authorization` header');
    }
}
