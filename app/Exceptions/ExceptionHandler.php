<?php


namespace App\Exceptions;

use Neutrino\Exceptions\AjaxMismatchException;
use Neutrino\Exceptions\TokenMismatchException;
use Neutrino\Foundation\Debug\Exceptions\ExceptionHandler as BaseExceptionHandler;
use Phalcon\Http\Response;

/**
 * Class ExceptionHandler
 *
 * @package App\Exceptions
 */
class ExceptionHandler extends BaseExceptionHandler
{
    /**
     * Report any exception/error.
     *
     * Fateful and not fateful exception/error will may be reported.
     *
     * @param \Exception|\Throwable $throwable
     */
    public function report($throwable)
    {
        if ($throwable instanceof TokenMismatchException ||
            $throwable instanceof AjaxMismatchException ||
            $throwable instanceof AlreadyAuthenticatedException) {
            // don't report token/ajax mismatch, already authenticated, exceptions
            return;
        }

        parent::report($throwable);
    }

    /**
     * Render any exception/error, in Web context.
     *
     * Only fateful exception/error will may be rendered.
     *
     * @param \Exception|\Throwable          $throwable
     * @param \Phalcon\Http\RequestInterface $request
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function render($throwable, $request = null)
    {
        if ($throwable instanceof TokenMismatchException) {
            if ($request->isAjax()) {
                // according to laravel token mismatch, return custom HTTP code <419 Token Mismatch>
                return new Response(null, 419, 'Token Mismatch');
            }

            // redirect any token mismatch to home.
            return (new Response)->redirect('/');
        }

        if ($throwable instanceof AjaxMismatchException) {
            return new Response(null, 400, 'Bad Request');
        }

        if ($throwable instanceof AlreadyAuthenticatedException) {
            return (new Response)->redirect('/');
        }

        return parent::render($throwable, $request);
    }

    /**
     * Render any exception/error, in Cli context.
     *
     * Fateful and not fateful exception/error will may be reported.
     *
     * @param \Exception|\Throwable $throwable
     */
    public function renderConsole($throwable)
    {
        parent::renderConsole($throwable);
    }
}
