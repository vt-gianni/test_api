<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RestaurantController extends AbstractController
{
    public function __invoke(RestaurantRepository $repository)
    {
        return $repository->findAll();
    }
}