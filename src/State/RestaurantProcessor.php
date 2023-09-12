<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Restaurant;
use Doctrine\ORM\EntityManagerInterface;

class RestaurantProcessor implements ProcessorInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        /** @var Restaurant $data */
        if (!$data->getAddress()) {
            $data->setAddress('Aucune adresse définie');
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}