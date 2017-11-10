<?php

// This is fix of issue #1110 in doctrine/dbal
// https://github.com/doctrine/dbal/issues/1110
//
// Author: Melkij (https://github.com/Melkij)

namespace App\Common\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;

class MigrationEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'postGenerateSchema',
        );
    }

    public function postGenerateSchema(GenerateSchemaEventArgs $Args)
    {
        $Schema = $Args->getSchema();

        if (! $Schema->hasNamespace('public')) {
            $Schema->createNamespace('public');
        }
    }
}
