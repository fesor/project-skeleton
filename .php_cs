<?php

use \PhpCsFixer\Finder;
use PhpCsFixer\Config;

return Config::create()
    // use default SYMFONY_LEVEL and extra fixers:
    ->setRules(array(
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => true
    ))
    ->setFinder(
        Finder::create()->in([
            __DIR__.'/src'
        ])
    )
;
