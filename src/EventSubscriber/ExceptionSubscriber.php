<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * Return JsonResponse depending of the Exception catch
     * An error 404 for no Route found
     * An error 400 for specific Exception like 'Json Syntax error'
     * 
     * @param Exception $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if (($exception instanceof NotFoundHttpException) || ($exception instanceof MethodNotAllowedHttpException)){
            $error = [
                'status' => $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ];            
            $response = new JsonResponse($error, JsonResponse::HTTP_NOT_FOUND);
        } else {
            $response = new JsonResponse(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
