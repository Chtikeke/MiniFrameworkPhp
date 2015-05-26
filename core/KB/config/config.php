<?php

use DI\Container;

return [
    'doctrine.metadataconfig' => \DI\factory(function(Container $c) {
        return Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            [\DI\string(__DIR__ . '/../../../src/')],
            true,
            null,
            null,
            false
        );
    }),

    '@entity_manager' => \DI\factory(function (Container $c) {
        return \Doctrine\ORM\EntityManager::create(
            $c->get('doctrine')['default'],
            $c->get('doctrine.metadataconfig')
        );
    }),

    '@php_view_render' => \DI\factory(function (Container $c) {
        return new \KB\Views\PhpViewRenderer(__DIR__ . '/../../../'. $c->get('views')['directory']);
    }),

    '@security_context' => \DI\factory(function (Container $c) {
        return new \KB\Security\SecurityContext(
            new \KB\Session\SessionManager(),
            $c->get('security')['userclassname']
        );
    }),

    'KB\Controller\AbstractController' => \DI\Object()
        ->property('viewRenderer', \DI\get('@php_view_render')),
];
