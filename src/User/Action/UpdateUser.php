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
    
    #[Route(path: '/users/{id}/update', name: 'user.update.json', methods: ['PUT'])]
    public function __invoke(Request $request, $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        
        foreach($request->request as $key => $val) {
            $setter = 'set' . ucfirst($key);
            $user->$setter($val);
        }
        
        $user->setUpdatedAt(new \DateTimeImmutable('now'));
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        $json = $this->serializer->serialize($user, 'json');
        
        return new Response($json, 200, [
            "content-type" => "application/json"
        ]);
    }
    
}
