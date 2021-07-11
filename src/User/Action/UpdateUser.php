<?php

namespace App\User\Action;

use App\Address\Helper as AddressHelper;
use App\User\Entity\User;
use App\User\Helper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class UpdateUser {
    
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ) {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(), new DateTimeNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->entityManager = $entityManager;
    }
    
    #[Route(path: '/users/{user_id}/update', name: 'user.update.json', methods: ['PUT'])]
    public function __invoke(Request $request, int $user_id): Response
    {
        $parameters = json_decode($request->getContent(), true);
        $user = $this->entityManager->getRepository(User::class)->find($user_id);
        $address = $user->getAddress();
        
        if(!empty($parameters['address'])) {
            $address = AddressHelper::updateAddress($address->getId(), $parameters['address'], $this->entityManager);
        }
    
        $updated_user = Helper::updateUser($user, $parameters['user'],$address ?? null, $this->entityManager);
        
        $json = $this->serializer->serialize($updated_user, 'json');
        
        return new Response($json, 200, [
            "content-type" => "application/json"
        ]);
    }
    
}
