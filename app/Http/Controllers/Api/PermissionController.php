<?php

namespace App\Http\Controllers\API;

class PermissionController extends ApiController
{
    /**
     * Get all permission from config file
     * @return json response
     */
    public function index()
    {
        $permissions = config('permissions');
        return response()->json($permissions, 200);
    }
}
