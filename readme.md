# 用法

Import Package：

```bash
composer require "shellphy/slim4-response"
```

Usage：

```php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Shellphy\Slim4Response\SlimConfigurator;

$app = SlimConfigurator::configure();

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("hello, world");
    return $response;
});

$app->get('/error', function (Request $request, Response $response, $args) {
    throw new \Exception("error", 400);
});

```

If you request GET /, response this:

```json
{
    "code": 0,
    "msg": "success",
    "data": "hello, world"
}
```

If you request GET /error, response this: 

```json
{
    "code": 400,
    "msg": "error",
    "data": null
}
```
