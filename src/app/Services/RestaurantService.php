<?php

namespace App\Services;

use App\Repositories\RestaurantRepository;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RestaurantService extends ApiBaseService
{
    /**
     * @var RestaurantRepository
     */
    protected $restaurantRepository;

    /**
     * RestaurantService constructor.
     * @param RestaurantRepository $restaurantRepository
     */
    public function __construct(RestaurantRepository $restaurantRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        DB::beginTransaction();
        try {
            $rider =  $this->restaurantRepository->create($data);
            DB::commit();
            return $this->sendSuccessResponse($rider, 'New Restaurant created successfully!', ResponseAlias::HTTP_CREATED);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendErrorResponse($exception->getMessage(), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
