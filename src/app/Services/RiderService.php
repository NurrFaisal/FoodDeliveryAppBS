<?php

namespace App\Services;

use App\Models\Restaurant;
use App\Models\RiderLocation;
use App\Repositories\RiderLocationRepository;
use App\Repositories\RiderRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RiderService extends ApiBaseService
{
    /**
     * @var RiderRepository
     */
    protected $riderRepository;
    /**
     * @var RiderLocationRepository
     */
    protected $riderLocationRepository;

    /**
     * RiderService constructor.
     * @param RiderRepository $riderRepository
     * @param RiderLocationRepository $riderLocationRepository
     */
    public function __construct(RiderRepository $riderRepository, RiderLocationRepository $riderLocationRepository)
    {
        $this->riderRepository = $riderRepository;
        $this->riderLocationRepository = $riderLocationRepository;
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function create($data)
    {
        DB::beginTransaction();
        try {
            $rider =  $this->riderRepository->create($data);
            DB::commit();
            return $this->sendSuccessResponse($rider, 'New Rider Created Successfully!', ResponseAlias::HTTP_CREATED);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendErrorResponse($exception->getMessage(), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeRiderLocation($data)
    {
        DB::beginTransaction();
        try {
            $riderLocation = $this->riderLocationRepository->create($data);
            DB::commit();
            return $this->sendSuccessResponse($riderLocation, 'New Rider Location Created Successfully!', ResponseAlias::HTTP_CREATED);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendErrorResponse($exception->getMessage(), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $restaurantId
     * @return array
     */
    public function nearByRider($restaurantId): JsonResponse
    {
        try {
            $data = [];
            $latestRiderLocations = $this->getLatestRiderLocations($restaurantId);

            // calculate nearest rider
            $restaurant = Restaurant::find($restaurantId);
            $nearestRider = null;
            $minDistance = PHP_INT_MAX;

            foreach($latestRiderLocations as $rider) {
                // calculate distance of a rider
                $distance = $this->distanceCalculator($restaurant->lat, $rider->lat, $restaurant->long, $rider->long);

                if ($distance < $minDistance) {
                    $minDistance = $distance;
                    $nearestRider = $rider;
                }
            }

            // format return data
            if ($nearestRider) {
                $data['rider_name'] = $nearestRider->rider->name;
                $data['min_distance'] = $minDistance;
            }

            return $this->sendSuccessResponse($data, 'Nearby rider selected!', ResponseAlias::HTTP_CREATED);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendErrorResponse($exception->getMessage(), ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    /**
     * @param $restaurantId
     * @return mixed
     */
    private function getLatestRiderLocations($restaurantId)
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $fiveMinutesBefore = Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s');

        // get all rider locations of last five minutes
        $ridersOfLastFiveMinutes = RiderLocation::where('capture_time', '<=', $now)
            ->where('capture_time', '>=', $fiveMinutesBefore)
            ->get();

        // group riders with their latest time
        $latestRiderLocations = $ridersOfLastFiveMinutes->groupBy('rider_id')->map(function ($group) {
            return $group->sortByDesc('capture_time')->first();
        });

        return $latestRiderLocations;
    }

    /**
     * @param $latRes
     * @param $latRider
     * @param $longRes
     * @param $longRider
     * @return float|int
     */
    private function distanceCalculator($latRes, $latRider, $longRes, $longRider)
    {
        $earthRadius = 6371000; // Earth radius in meters

        // convert from degrees to radians
        $latFrom = deg2rad($latRes);
        $longFrom = deg2rad($longRes);
        $latTo = deg2rad($latRider);
        $longTo = deg2rad($longRider);

        $latDelta = $latTo - $latFrom;
        $longDelta = $longTo - $longFrom;

        // calculate angle
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($longDelta / 2), 2)));

        return $angle * $earthRadius; // distance in meters
    }
}
