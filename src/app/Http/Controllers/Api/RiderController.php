<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RiderLocationRequest;
use App\Http\Requests\RiderRequest;
use App\Services\RiderService;
use Illuminate\Http\JsonResponse;

class RiderController extends Controller
{
    /**
     * @var RiderService
     */
    private $riderService;

    /**
     * RiderController constructor.
     * @param RiderService $riderService
     */
    public function __construct(RiderService $riderService)
    {
        $this->riderService = $riderService;
    }

    /**
     * Store a newly created rider in database.
     */
    public function create(RiderRequest $request): JsonResponse
    {
        return $this->riderService->create($request->all());
    }

    /**
     * Store a rider location in database.
     */
    public function storeRiderLocation(RiderLocationRequest $request): JsonResponse
    {
        return $this->riderService->storeRiderLocation($request->all());
    }

    /**
     * @param $restaurantId
     * @return JsonResponse
     */
    public function getNearbyRider($restaurantId): JsonResponse
    {
        return  $this->riderService->nearByRider($restaurantId);
    }
}
