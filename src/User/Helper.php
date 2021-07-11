<?php

namespace App\User;

use App\Address\Entity\Address;
use App\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class Helper {
    
    public static function createUser(array $user, Address $address, EntityManagerInterface $entityManager): User
    {
        $new_user = new User();
    
        foreach($user as $key => $val) {
            $setter = 'set' . ucfirst($key);
            $new_user->$setter($val);
        }
        $new_user->setCreatedAt(new \DateTimeImmutable('now'));
        $new_user->setAddress($address);
        
        $entityManager->persist($new_user);
        $entityManager->flush();
        
        return $new_user;
    }
    
    public static function updateUser($user, array $new_user, ?Address $address, EntityManagerInterface $entityManager): User
    {
        
        foreach($new_user as $key => $val) {
            $setter = 'set' . ucfirst($key);
            $user->$setter($val);
        }
        
        $user->setUpdatedAt(new \DateTimeImmutable('now'));
        if($address !== null) {
            $user->setAddress($address);
        }
        
        $entityManager->flush();
        
        return $user;
    }
}
