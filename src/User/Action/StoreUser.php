<?php

namespace App\User\Action;

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
        $new_user = new User();
        foreach($request->request as $key => $val) {
            $setter = 'set' . ucfirst($key);
            $new_user->$setter($val);
        }
        $new_user->setCreatedAt(new \DateTimeImmutable('now'));
        
        $this->entityManager->persist($new_user);
        $this->entityManager->flush();
        
        $json = $this->serializer->serialize($new_user, 'json');
        
        return new Response($json, 200, [
            "content-type" => "application/json"
        ]);
    }
    
}
