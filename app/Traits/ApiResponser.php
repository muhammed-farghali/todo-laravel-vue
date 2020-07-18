<?php

namespace App\Traits;

trait ApiResponser
{
    protected function successResponse ( $data, $successCode, $message = null, $code = 200 )
    {
        return response()->json( [
            'success' => true,
            'code'    => $successCode,
            'message' => $message,
            'data'    => $data
        ], $code );
    }

    protected function errorResponse ( $errorCode, $message = null, $code )
    {
        return response()->json( [
            'success' => false,
            'code'    => $errorCode,
            'message' => $message,
            'data'    => null
        ], $code );
    }

}
