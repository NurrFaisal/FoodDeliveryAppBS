<?php

namespace App\Repositories;
use App\Models\Rider;

/**
 * Class RiderRepository
 * @package App\Repositories
 */
class RiderRepository
{
    /**
     * @var string
     */
    protected $modelName = Rider::class;

    /**
     * RiderRepository constructor.
     * @param Rider $model
     */
    public function __construct(Rider $model)
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
