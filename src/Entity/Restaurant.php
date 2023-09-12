<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\RestaurantController;
use App\Repository\RestaurantRepository;
use App\State\RestaurantProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/{id}',
            requirements: ['id' => '\d+']
        ),
        new GetCollection(
            uriTemplate: '/'
        ),
        new GetCollection(
            uriTemplate: '/test',
            controller: RestaurantController::class
        ),
        new Post(
            uriTemplate: "",
            processor: RestaurantProcessor::class
        )
    ],
    routePrefix: '/restaurants',
    normalizationContext: ["groups" => ["restaurant_read"]],
    denormalizationContext: ["groups" => ["restaurant_write"]]
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'exact'])]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["restaurant_read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le champ 'name' est obligatoire.")]
    #[Groups(["restaurant_read", "restaurant_write"])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["restaurant_read", "restaurant_write"])]
    private ?string $address = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }
}
