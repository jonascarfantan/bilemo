<?php

namespace App\Customer\Action;

use App\Customer\Entity\Customer;
use App\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class DeleteCustomer {
    
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ) {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(), new DateTimeNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->entityManager = $entityManager;
    }
    
    #[Route(path: '/customers/{id}/delete', name: 'customer.delete.json', methods: ['DELETE'])]
    public function __invoke(Request $request, $id): Response
    {
        $customer = $this->entityManager->getRepository(Customer::class)->find($id);
        
        $this->entityManager->remove($customer);
        $this->entityManager->flush();
        
        $json = json_encode(['message' => 'User successfully deleted']);
        
        return new Response($json, 200, [
            "content-type" => "application/json"
        ]);
    }
    
}
