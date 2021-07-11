<?php

namespace App\Address;

use App\Address\Entity\Address;
use Doctrine\ORM\EntityManagerInterface;
use function Sodium\add;

class Helper {
    
    public static function createAddress(array $address, EntityManagerInterface $entityManager): Address
    {
        $new_address = new Address();
    
        foreach($address as $key => $val) {
            $setter = 'set' . ucfirst($key);
            $new_address->$setter($val);
        }
        $new_address->setCreatedAt(new \DateTimeImmutable('now'));
        
        $entityManager->persist($new_address);
        $entityManager->flush();
        
        return $new_address;
    }
    
    public static function updateAddress(int $address_id, array $new_address, EntityManagerInterface $entityManager): Address
    {
        $address = $entityManager->getRepository(Address::class)->find($address_id);
        
        foreach($new_address as $key => $val) {
            $setter = 'set' . ucfirst($key);
            $address->$setter($val);
        }
        
        $address->setCreatedAt(new \DateTimeImmutable('now'));
        
        $entityManager->persist($address);
        $entityManager->flush();
        
        return $address;
    }
}
