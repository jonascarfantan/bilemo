<?php

namespace App\Customer\Entity;

use App\Address\Entity\Address;
use App\Customer\Repository\CustomerRepository;
use App\User\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use JetBrains\PhpStorm\Pure;

#[Entity(repositoryClass: CustomerRepository::class, readOnly: false)]
class Customer
{
    
    #[Id, Column(type: 'integer'), GeneratedValue]
    private $id;
    
    #[Column(type:'string', length: 64, unique: true, nullable: false)]
    private string $business_name;
    
    #[Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $created_at;
    
    #[Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;
    
    #[OneToOne(targetEntity: Address::class), JoinColumn(name: 'address_id', referencedColumnName: "id", onDelete: 'cascade')]
    private Address $address;
    
    #[OneToMany(mappedBy: 'customer', targetEntity: User::class)]
    private Collection $users;
    
    #[Pure] public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getBusinessName(): string {
        return $this->business_name;
    }
    
    public function setBusinessName($business_name): self {
        $this->business_name = $business_name;
        
        return $this;
    }
    
    public function getCreatedAt(): ?\DateTimeImmutable {
        return $this->created_at;
    }
    
    public function setCreatedAt(?\DateTimeImmutable $created_at): self {
        $this->created_at = $created_at;
        
        return $this;
    }
    
    public function getUpdatedAt(): ?\DateTimeImmutable {
        return $this->updated_at;
    }
    
    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self {
        $this->updated_at = $updated_at;
        
        return $this;
    }
    
    public function getAddress() {
        return $this->address;
    }
    
/////////////////
// RELATIONSHIP
/////////////////
    
    public function setAddress($address): self {
        $this->address = $address;
        
        return $this;
    }
}
