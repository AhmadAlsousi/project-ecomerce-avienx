<?php

namespace App\Http\Controllers;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Laravel CRUD API",
 *         version="1.0.0",
 *         description="User Management API"
 *     ),
 *     @OA\Server(
 *         url="http://localhost:8000",
 *         description="Local Server"
 *     )
 * )
 */
abstract class APIController
{

  public function sendResponce($data = null, $message = null, $code = 200, $withPagination = false)
{
    if ($data instanceof \Illuminate\Http\Resources\Json\ResourceCollection) {
        $resourceArray = $data->response()->getData(true);
        $responseData = [
            'success' => $code == 200 || $code == 201,
            'data' => $resourceArray['data'] ?? null,
            'message' => $message,
        ];
        if (isset($resourceArray['meta'])) {
            $responseData['pagination'] = $resourceArray['meta'];
        }
        return response()->json($responseData, $code);
    }

    $responseData = [
        'success' => $code == 200 || $code == 201,
        'data' => $data,
        'message' => $message,
    ];

    if ($withPagination && $data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
        $responseData['pagination'] = $this->getPaginationData($data);
    }

    return response()->json($responseData, $code);
}

    public function sendError($message, $code = 400)
    {
        return response()->json([
            'success' => false,
            'data' => null,
            'message' => $message,
        ], $code);
    }

    public function getPaginationData($collection)
    {
        return [
            'current_page' => $collection->currentPage(),
            'next_page_url' => $collection->nextPageUrl(),
            'prev_page_url' => $collection->previousPageUrl(),
            'first_page_url' => $collection->url(1),
            'last_page_url' => $collection->url($collection->lastPage()),
            'per_page' => $collection->perPage(),
            'total' => $collection->total()
        ];
    }
}
