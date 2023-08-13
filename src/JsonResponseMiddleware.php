<?php

namespace Shellphy\Slim4Response;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class JsonResponseMiddleware {
    public function __invoke(Request $request, RequestHandler $handler): Response {
        $response = $handler->handle($request);
        $formattedResponse = new \Slim\Psr7\Response();
        $body = $response->getBody();
        $array_body = json_decode($body, true);
        $formattedResponse->getBody()->write(json_encode([
            'code' => 0,
            'msg' => 'success',
            'data' => is_array($array_body) ? $array_body : (string)$body,
        ]));
        return $formattedResponse->withHeader('Content-Type', 'application/json');
    }
}
