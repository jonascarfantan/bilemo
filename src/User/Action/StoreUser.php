<?php

namespace App\User\Action;

use App\Address\Helper as AddressHelper;
use App\User\Helper as UserHelper;
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

class StoreUser {
    
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ) {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(), new DateTimeNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->entityManager = $entityManager;
    }
    
    #[Route(path: '/users/store', name: 'user.store.json', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $parameters = json_decode($request->getContent(), true);
        $address = AddressHelper::createAddress($parameters['address'], $this->entityManager);
        $user = UserHelper::createUser($parameters['user'], $address, $this->entityManager);
        
        $json = $this->serializer->serialize($user, 'json');
        
        return new Response($json, 200, [
            "content-type" => "application/json"
        ]);
    }
    
}
