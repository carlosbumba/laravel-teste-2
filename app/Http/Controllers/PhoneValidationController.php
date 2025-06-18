<?php

namespace App\Http\Controllers;

use App\Http\Resources\NumVerifyResource;
use App\Services\NumVerifyService;
use Illuminate\Http\Request;

class PhoneValidationController extends Controller
{
    public function __construct(protected NumVerifyService $service) {}

    public function __invoke(Request $request)
    {
        $request->validate([
            'number' => 'required|string'
        ]);

        $data = $this->service->validate($request->number, $request->country_code);

        if (isset($data['error'])) {
            return response()->json($data, 400);
        }

        return new NumVerifyResource($data);
    }
}
