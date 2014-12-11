<?php

require __DIR__. '/vendor/autoload.php';

$phpLoader = new \Iut\Config\PhpLoader([__DIR__ . '/config/app.php']);
print_r($phpLoader->load());