<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

/**
 * FastRoute route configuration
 *
 * @see https://github.com/nikic/FastRoute
 *
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/{id:\d+}', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Mezzio\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/metrics[/]', Common\Handler\MetricsHandler::class, 'metrics');

    /* this routes for test */
    $app->get('/test/logging[/]', Votocracy\Handler\LoggingHandler::class, 'test.logging');
    $app->get('/test/debugging[/]', Votocracy\Handler\DebuggingHandler::class, 'test.debugging');
    $app->get('/test/api/ping[/]', Votocracy\Handler\PingHandler::class, 'api.ping');
    $app->get('/test/api/user/{id}[/]', Votocracy\Handler\UserHandler::class, 'test.api.get.user')
        ->setOptions([
            'tokens' => [
                'id' => '\d+',
            ],
        ]);
    $app->get(
        '/test/authentication[/]',
        [
            Common\Middleware\JwtMiddleware::class,
            Votocracy\Handler\AuthenticationHandler::class,
        ],
        'test.authentication'
    );
    $app->post('/test/api/event-produce[/]', Votocracy\Handler\EventProduceHandler::class, 'test.api.event-produce');
    $app->get('/test/api/event-consume[/]', Votocracy\Handler\EventConsumeHandler::class, 'test.api.event-consume');
};
