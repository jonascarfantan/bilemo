<?php

namespace App\Customer\Action;

use App\Customer\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class GetCustomers {
    
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ) {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(), new DateTimeNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->entityManager = $entityManager;
    }
    
    #[Route(path: '/customers', name: 'customers.json', methods: ['GET', 'HEAD'])]
    public function __invoke(Request $request): Response
    {
        $customers = $this->entityManager->getRepository(Customer::class)->findAll();
        $json = $this->serializer->serialize($customers, 'json');
//        $json = json_encode($users);
        
        return new Response($json, 200, [
            "content-type" => "application/json"
        ]);
    }
    
}
