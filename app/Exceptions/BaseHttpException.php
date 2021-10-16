<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseHttpException extends Exception
{
    protected int $resCode = 500;
    protected string $resMsg = 'Undefined error';

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function render(Request $request): Response|JsonResponse
    {
        if(
            $request->isJson()
            || $request->is('v1/*')
        ) return $this->getJsonResponse();

        return $this->getResponse();
    }

    private function getResponse(): Response
    {
        return response($this->resMsg, $this->resCode);
    }

    private function getJsonResponse(): JsonResponse
    {
        return response()->json([
            'error' => [
                'code' => $this->resCode,
                'message' => $this->resMsg,
            ],
        ], $this->resCode);
    }
}
