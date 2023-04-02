<?php

use Laminas\Hydrator\ClassMethodsHydrator;
use Votocracy\Entity;
use Mezzio\Hal\Metadata\MetadataMap;
use Mezzio\Hal\Metadata\RouteBasedCollectionMetadata;
use Mezzio\Hal\Metadata\RouteBasedResourceMetadata;

return [
    MetadataMap::class => [
        [
            '__class__' => RouteBasedResourceMetadata::class,
            'resource_class' => Entity\User::class,
            'route' => 'test.api.get.user',
            'extractor' => ClassMethodsHydrator::class,
        ],
    ],
];
