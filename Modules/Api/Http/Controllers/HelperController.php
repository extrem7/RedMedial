<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;

class HelperController extends Controller
{
    public function root(): JsonResponse
    {
        return response()->json([
            'message' => 'Hello, api user!'
        ]);
    }
}
