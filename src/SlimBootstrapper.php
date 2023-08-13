<?php

namespace Shellphy\Slim4Response;

use Throwable;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Shellphy\Slim4Response\JsonResponseMiddleware;

class SlimBootstrapper 
{
    public static function bootstrap(array $settings = []): \Slim\App 
    {
        // 初始化Slim应用
        $app = AppFactory::create();

        // 添加统一的 JSON 响应中间件
        $app->add(new JsonResponseMiddleware());

        // 错误处理
        $customErrorHandler = function (
            ServerRequestInterface $request,
            Throwable $exception,
            bool $displayErrorDetails,
            bool $logErrors,
            bool $logErrorDetails,
            ?LoggerInterface $logger = null
        ) use ($app) {
            if ($logger) {
                $logger->error($exception->getMessage());
            }
            $payload = [
                'code' => $exception->getCode(), 
                'msg' => $exception->getMessage(),
                'data' => null
            ];
            $response = $app->getResponseFactory()->createResponse();
            $response->getBody()->write(
                json_encode($payload, JSON_UNESCAPED_UNICODE)
            );
            return $response;
        };

        $errorMiddleware = $app->addErrorMiddleware(true, true, true);
        $errorMiddleware->setDefaultErrorHandler($customErrorHandler);

        return $app;
    }
}
