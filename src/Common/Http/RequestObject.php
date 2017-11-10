<?php

namespace App\Common\Http;

use Fesor\RequestObject\ErrorResponseProvider;
use Fesor\RequestObject\RequestObject as BaseRequestObject;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class RequestObject extends BaseRequestObject implements ErrorResponseProvider
{
    public function getErrorResponse(ConstraintViolationListInterface $errors)
    {
        return new JsonResponse(
            [
                'status_code' => 422,
                'message' => 'Invalid data in request body',
                'errors' => array_map(function (ConstraintViolation $violation) {
                    return [
                        'path' => $violation->getPropertyPath(),
                        'message' => $violation->getMessage(),
                    ];
                }, iterator_to_array($errors)),
            ],
            422
        );
    }
}
