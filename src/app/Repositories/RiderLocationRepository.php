<?php

namespace App\Repositories;
use App\Models\Rider;
use App\Models\RiderLocation;

/**
 * Class RiderLocationRepository
 * @package App\Repositories
 */
class RiderLocationRepository
{
    /**
     * @var string
     */
    protected $modelName = RiderLocation::class;

    /**
     * RiderLocationRepository constructor.
     * @param RiderLocation $model
     */
    public function __construct(RiderLocation $model)
    {
        $this->model = $model;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->model->create($data);
    }
}
