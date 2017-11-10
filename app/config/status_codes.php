<?php

$statusCodes = [
    // framework specific
    \Symfony\Component\Routing\Exception\ResourceNotFoundException::class => 404,
    \Doctrine\ORM\OptimisticLockException::class => 409,
];

// do not touch
$container->loadFromExtension('fos_rest', ['exception' => ['codes' => $statusCodes]]);
