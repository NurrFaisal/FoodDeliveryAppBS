<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRequest;
use App\Services\RestaurantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RestaurantController extends Controller
{
    /**
     * @var RestaurantService
     */
    protected $restaurantService;

    /**
     * RestaurantController constructor.
     * @param RestaurantService $restaurantService
     */
    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    /**
     * @param RestaurantRequest $request
     * @return JsonResponse
     */
    public function create(RestaurantRequest $request)
    {
        return $this->restaurantService->create($request->all());
    }
}
