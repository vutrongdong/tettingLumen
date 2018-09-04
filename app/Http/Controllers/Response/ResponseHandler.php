<?php

namespace App\Http\Controllers\Response;

use App\Http\Transformers\OptimusPrime;

trait ResponseHandler
{
    public $transform;

    protected function setTransformer($transform)
    {
        $this->transform = $transform;
    }

    protected function successResponse($data, $transform = true)
    {
        if (is_null($data)) {
            $data = [];
        }

        if (property_exists($this, 'useTransform')) {
            $transform = $this->useTransform;
        }

        if ($transform) {
            $response = array_merge([
                'code' => 200,
                'status' => 'success',
            ], $this->transform($data));
            return response()->json($response, $response['code']);
        } else {
            $response = array_merge([
                'code' => 200,
                'status' => 'success',
            ], $data);
            return response()->json($response, 200);
        }
    }

    protected function notFoundResponse()
    {
        $response = [
            'code' => 404,
            'status' => 'error',
            'data' => 'Resource Not Found',
            'message' => 'Not Found'
        ];
        return response()->json($response, $response['code']);
    }

    public function deleteResponse()
    {
        $response = [
            'code' => 200,
            'status' => 'success',
            'data' => [],
            'message' => 'Resource Deleted'
        ];
        return response()->json($response, $response['code']);
    }

    public function errorResponse($data)
    {
        $response = [
            'code' => 422,
            'status' => 'error',
            'data' => $data,
            'message' => 'Unprocessable Entity'
        ];
        return response()->json($response, $response['code']);
    }

    private function transform($data)
    {
        try {
            $optimus = app()->make(OptimusPrime::class);
            return $optimus->transform($data, $this->transform);
        } catch (\Exception $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw $t;
        }
    }
}
