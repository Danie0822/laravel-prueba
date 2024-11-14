<?php

namespace App\Responses;

class ResponseMessages
{
    /**
     * Generar una respuesta de éxito en JSON.
     *
     * @param mixed $data Los datos a incluir en la respuesta.
     * @param string $message El mensaje de éxito.
     * @param int $code El código HTTP (por defecto 200).
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = null, $message = 'Operación exitosa', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Generar una respuesta de error en JSON.
     *
     * @param string $message El mensaje de error.
     * @param int $code El código HTTP (por defecto 500).
     * @param \Exception|null $exception Opcional: detalles adicionales de la excepción.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message = 'Ha ocurrido un error', $code = 500, \Exception $exception = null)
    {
        $errorMessage = $exception ? $message . ' - ' . $exception->getMessage() : $message;

        return response()->json([
            'success' => false,
            'message' => $errorMessage,
            'data' => null,
        ], $code);
    }
}
