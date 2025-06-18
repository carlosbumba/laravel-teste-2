<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneValidationRequest;
use App\Http\Resources\NumVerifyResource;
use App\Services\NumVerifyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class PhoneValidationController extends Controller
{
    public function __construct(protected NumVerifyService $service) {}

    public function __invoke(PhoneValidationRequest $request): JsonResource|JsonResponse
    {
        $data = $this->service->validate($request->number, $request->country_code);

        if (isset($data['error'])) {
            return response()->json($data, 400);
        }

        return new NumVerifyResource($data);
    }
}
