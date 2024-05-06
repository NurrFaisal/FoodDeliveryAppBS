<?php

namespace App\Repositories;
use App\Models\Restaurant;

/**
 * Class RestaurantRepository
 * @package App\Repositories
 */
class RestaurantRepository
{
    /**
     * @var string
     */
    protected $modelName = Restaurant::class;

    /**
     * RestaurantRepository constructor.
     * @param Restaurant $model
     */
    public function __construct(Restaurant $model)
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
