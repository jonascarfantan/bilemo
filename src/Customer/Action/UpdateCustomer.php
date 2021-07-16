<?php

namespace App\Customer\Action;

use App\Address\Helper as AddressHelper;
use App\Customer\Entity\Customer;
use App\User\Entity\User;
use App\Customer\Helper as CustomerHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class UpdateCustomer {
    
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ) {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(), new DateTimeNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->entityManager = $entityManager;
    }
    
    #[Route(path: '/customers/{customer_id}/update', name: 'user.update.json', methods: ['PUT'])]
    public function __invoke(Request $request, int $customer_id): Response
    {
        $parameters = json_decode($request->getContent(), true);
        $user = $this->entityManager->getRepository(Customer::class)->find($customer_id);
        $address = $user->getAddress();
        
        if(!empty($parameters['address'])) {
            $address = AddressHelper::updateAddress($address->getId(), $parameters['address'], $this->entityManager);
        }
    
        $updated_user = CustomerHelper::updateCustomer($user, $parameters['customer'],$address ?? null, $this->entityManager);
        
        $json = $this->serializer->serialize($updated_user, 'json');
        
        return new Response($json, 200, [
            "content-type" => "application/json"
        ]);
    }
    
}
