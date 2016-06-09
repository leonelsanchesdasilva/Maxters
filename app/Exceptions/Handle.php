<?php

namespace Maxters\Exceptions;

use Maxters\Container;
use PHPLegends\Http\Response;
use PHPLegends\Http\Exceptions\NotFoundException;
use PHPLegends\Http\Exceptions\HttpExceptionInterface;

class Handle
{
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public function render(\Exception $exception)
    {
        if ($exception instanceof NotFoundException) {

            return $this->createHttpExceptionView('error/not_found', $exception);

        } elseif ($exception instanceof HttpExceptionInterface) {

            return $this->createHttpExceptionView('error/default', $exception);
        }

        return $this->createExceptionView('error/default', $exception);

    }

    protected function createResponse($content, $status)
    {
        return (new Response($content, $status))->send();
    }

    protected function createHttpExceptionView($view, \Exception $exception)
    {
        $status = $exception->getResponse()->getStatusCode();

        return $this->createExceptionView($view, $exception, $status);
    }

    protected function createExceptionView($view, \Exception $exception, $status = 500)
    {
        $fileObject = new \SplFileObject($exception->getFile(), 'r');

        $errorLines = new \LimitIterator(
            $fileObject, $exception->getLine() - 5, $exception->getLine() + 5
        );

        $view = $this->app['view']->create($view, compact('exception', 'errorLines'));

        return $this->createResponse($view, $status);
    }
}