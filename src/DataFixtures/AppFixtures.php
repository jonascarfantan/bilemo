<?php

namespace App\DataFixtures;

use App\Address\Entity\Address;
use App\Customer\Entity\Customer;
use App\User\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public const USER_REFERENCE = 'user';
    
    private UserPasswordHasherInterface $encoder;
    private \Faker\Generator $faker;
    private \DateTimeImmutable $now;
    
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = Factory::create();
        $this->now = new \DateTimeImmutable('now');
    }
    
    public function load(ObjectManager $manager)
    {
        $roles = ['ADMIN','USER'];
        
        $user = new User();
        $user->setUsername('distributor')
            ->setEmail('distributor@bilemo.com')
            ->setRole('DISTRIBUTOR')
            ->setPassword('password')
            ->setFirstName('Jonas')
            ->setLastName('Carfantan');
        
        for($i = 0; $i < 10; $i++) {
            $address = $this->createAddress();
            $manager->persist($address);
            $customer = $this->createCustomer($address);
            $manager->persist($customer);
            
            for($j = 0; $j < 10; $j++) {
                $address_ = $this->createAddress();
                $manager->persist($address);
                $user = $this->createUser($address_, $roles, $customer);
                $manager->persist($user);
            }
        }
        
        $manager->flush();
    
        // other fixtures can get this object using the UserFixtures::ADMIN_USER_REFERENCE constant
        $this->addReference(self::USER_REFERENCE, $user);
    }
    
    private function createAddress(): Address
    {
        $address = new Address();
        
         $address->setCreatedAt($this->now)
            ->setCity($this->faker->city)
            ->setCityCode($this->faker->numberBetween(0,100))
            ->setCountry($this->faker->country)
            ->setStreet($this->faker->streetName)
            ->setStreetNumber($this->faker->numberBetween(0,100))
            ->setCompAddress($this->faker->macAddress);
         
         return $address;
    }
    
    private function createUser(Address $address, array $roles, ?Customer $customer = null ): User
    {
        $user = new User();
        
        return $user->setUsername($this->faker->userName)
            ->setFirstName($this->faker->firstName)
            ->setLastName($this->faker->lastName)
            ->setRole($roles[rand(0, count($roles) - 1)])
            ->setPassword('password')
            ->setEmail($this->faker->email)
            ->setAddress($address)
            ->setCustomer($customer)
            ->setCreatedAt($this->now);
        
    }
    
    private function createCustomer(Address $address): Customer
    {
        $customer = new Customer();
        
        return $customer->setBuisnessName($this->faker->company)
            ->setAddress($address)
            ->setCreatedAt($this->now);
    }
    
    
}
