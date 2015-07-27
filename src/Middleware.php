<?php
namespace Stratedge\Quint;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class Middleware {

    protected $request;
    protected $response;

    final public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $this->request = $request;
        $this->response = $response;

        $proceed = $this->before();

        if ($proceed !== false) {
            $this->response = $next($this->request, $this->response);

            $this->after();
        }

        return $this->response;
    }

    public function before()
    {
        return true;
    }

    public function after()
    {
        //No-op
    }

    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }

}
