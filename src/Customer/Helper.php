<?php

namespace App\Customer;

use App\Address\Entity\Address;
use App\Customer\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;

class Helper {
    
    public static function createCustomer(array $customer, Address $address, EntityManagerInterface $entityManager): Customer
    {
        $new_customer = new Customer();
    
        foreach($customer as $key => $val) {
            $setter = 'set' . ucfirst($key);
            $new_customer->$setter($val);
        }
        $new_customer->setCreatedAt(new \DateTimeImmutable('now'));
        $new_customer->setAddress($address);
        
        $entityManager->persist($new_customer);
        $entityManager->flush();
        
        return $new_customer;
    }
    
    public static function updateCustomer($customer, array $new_customer, ?Address $address, EntityManagerInterface $entityManager): Customer
    {
        
        foreach($new_customer as $key => $val) {
            $setter = 'set' . ucfirst($key);
            $customer->$setter($val);
        }
        
        $customer->setUpdatedAt(new \DateTimeImmutable('now'));
        if($address !== null) {
            $customer->setAddress($address);
        }
        
        $entityManager->flush();
        
        return $customer;
    }
}
