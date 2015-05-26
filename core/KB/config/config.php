<?php

use DI\Container;

return [
    'doctrine.metadataconfig' => \DI\factory(function(container $c) {
        return Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            [\DI\string(__DIR__ . '/../../../src/')],
            true,
            null,
            null,
            false
        );
    }),
    'entity_manager' => \DI\factory(function (Container $c) {
        return \Doctrine\ORM\EntityManager::create(
            $c->get('doctrine')['default'],
            $c->get('doctrine.metadataconfig')
        );
    }),
];
