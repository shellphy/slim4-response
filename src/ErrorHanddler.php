<?php

namespace Shellphy\Slim4Response;

use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Psr\Log\LoggerInterface;
use Slim\App;

class ErrorHandler {
    public static function handle(
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails,
        ?LoggerInterface $logger = null
    ) {
        if ($logger) {
            $logger->error($exception->getMessage());
        }
        $payload = [
            'code' => $exception->getCode(), 
            'msg' => $exception->getMessage(),
            'data' => null
        ];
        $response = (new App())->getResponseFactory()->createResponse();
        $response->getBody()->write(
            json_encode($payload, JSON_UNESCAPED_UNICODE)
        );
        return $response;
    }
}
