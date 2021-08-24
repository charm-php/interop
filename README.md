charm/psr-di
============

Whenever you write a library that needs to be interoperable with PSR, these
traits provide a simple way for your users to inject the expected implementations.

ExampleMiddleware
-----------------

```
<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * This example middleware logs messages using a PSR-3 Log implementation,
 * and returns new responses using a PSR-17 Http Factory implementation.
 */
class SomeMiddleware implements MiddlewareInterface {

    /**
     * We'll be logging the requests, so we need a `$this->logger()` method.
     */
    use Charm\Interop\InjectedLogger;

    /**
     * We want to create a response object but we don't want to roll our own
     */
    use Charm\Interop\InjectedResponseFactory;

    /**
     * Response objects contain streams
     */
    use Charm\Interop\InjectedStreamFactory;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface {

        // Log the request
        $this->logger()->info("{method} {requestTarget}", [
            'method' => $request->getMethod(),
            'requestTarget' => $request->getRequestTarget(),
        ]);

        if (mt_rand(0,1)) {
            // Create the response body
            $body = $this->streamFactory()->createStream("Sorry. I don't feel like serving you this page right now!");

            // Create the response
            $response = $this->responseFactory()->createResponse(200, ['Content-Type' => 'text/plain'], $body);

            return $response;
        }

        // We're not hijacking this request, so pass to the `$next` request handler
        return $next->handle($request);
    }

}